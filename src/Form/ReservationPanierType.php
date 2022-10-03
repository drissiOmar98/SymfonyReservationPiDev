<?php

namespace App\Form;

use App\Entity\ReservationPanier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationPanierType extends AbstractType
{
   // public function buildForm(FormBuilderInterface $builder, array $options): void
    //{
     //   $builder
      //      ->add('items')
       //     ->add('prix')
       // ;
   // }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservationPanier::class,
        ]);
    }
}
