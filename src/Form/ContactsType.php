<?php

namespace App\Form;

use App\Entity\Contacts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre Nom',
                ],            
            ])
            ->add('email', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre Email',
                ],
            ])
            ->add('objet', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Objet',
                ],
            ])
            ->add('message', TextareaType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre Message',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contacts::class,
        ]);
    }
}
