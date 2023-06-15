<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('date_heure_depart', DateTimeType::class, [
            'widget' => 'single_text',
            'label' => "Date et heure de réservation"
        ])
        ->add('date_heure_fin', DateTimeType::class, [
            'widget' => 'single_text',
            'label' => "Date et heure de rendue",
            'constraints' => [
                new GreaterThanOrEqual([
                    'propertyPath' => 'parent.all[date_heure_depart].data',
                    'message' => 'La date de fin doit être supérieure ou égale à la date de réservation.'
                ]),
            ],
        ])
            // ->add('prix_total')
            // ->add('date_enregistrement')
            // ->add('membre')
            // ->add('vehicule')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}