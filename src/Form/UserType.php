<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'attr' => [
                'placeholder' => "Entrez l'email"
            ]
        ])
            ->add('roles')
            ->add('password')
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'placeholder' => "Entrez le pseudo"
                ]
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => "Entrez le nom"
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'placeholder' => "Entrez le prénom"
                ]
            ])
            ->add('civilite', ChoiceType::class, [
                'choices' => [
                    'Homme' => "m",
                    'Femme' => 'f'
                ]
                ])
            ->add('date_enregistrement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
