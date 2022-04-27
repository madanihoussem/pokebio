<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Entity\Livraison;
use App\Repository\CommandesRepository;
use App\Repository\LivraisonRepository;
use App\Repository\ProduitsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class CommandesController extends AbstractController
{
    #[Route('/commandes', name: 'commandes')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('commandes/index.html.twig', [
            'controller_name' => 'CommandesController',
        ]);
    }
    
    #[Route('/checkout', name: 'checkout')]
    public function checkout(Request $request, SessionInterface $session, ProduitsRepository $produitsRepository, EntityManagerInterface $entityManager, CommandesRepository $commandesRepository): Response
    {
        if (in_array($request->request->get('cc-number'), ['4000002500001001', '5555552500001001'])) {
            $adresse = $request->request->get('adresse');
            $telephone = $request->request->get('telephone');
            $user = $this->getUser();
            $ref = uniqid();
            $commande = new Commandes();
            $commande->setReference($ref);
            $commande->setPrix($session->get("total"));
            $commande->setUser($user);
            foreach($session->get("panier") as $id => $quantite){
                $product = $produitsRepository->find($id);
                $commande->addProduit($product);
            }
            $entityManager->persist($commande);
            $entityManager->flush();
            $livraison = new Livraison();
            $livraison->setAdresse($adresse);
            $livraison->setTelephone($telephone);
            $livraison->setUser($user);
            $livraison->setCommande($commandesRepository->findOneBy(['reference' => $ref]));
            $entityManager->persist($livraison);
            $entityManager->flush();
            $session->set("reference", $commande->getReference());
            return $this->redirectToRoute('success');
        }
        return $this->render('commandes/index.html.twig', [
            'controller_name' => 'CommandesController',
        ]);
    }

    #[Route('/success', name: 'success')]
    public function success(Request $request, UserRepository $userRepository, SessionInterface $session, ProduitsRepository $produitsRepository, CommandesRepository $commandesRepository): Response
    {
        $panier = $session->get("panier", []);
        $dataPanier = [];
        $total = 0;
        $qte = 0;

        foreach($panier as $id => $quantite){
            $product = $produitsRepository->find($id);
            $dataPanier[] = [
                "produit" => $product,
                "quantite" => $quantite
            ];
            $total += $product->getPrix() * $quantite;
            $qte += $quantite;
        }
        $session->set("qte", $qte);
        $session->set("total", $total);
        $ref = $session->get("reference");
        $commande = $commandesRepository->findBy(['reference'=>$ref]);
        $session->set("commande", $commande);
        $session->set("panier", []);

        return $this->render('commandes/success.html.twig', compact("dataPanier", "total", "qte", "commande"));
        
    }
}
