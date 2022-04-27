<?php

namespace App\Form;

use App\Entity\Produits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom produit',
                ],
            ])
            ->add('description', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description',
                ],
            ])
            ->add('prix', NumberType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description',
                ],
            ])
            ->add('type', ChoiceType::class,[
                'choices'  => [
                    'Poké' => 'starters',
                    'Boisson' => 'specialty',
                    'Déssert' => 'salads',
                ],
                'placeholder' => '--Catégorie--',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
