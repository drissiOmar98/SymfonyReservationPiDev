<?php

namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('lieu',TextType::class,[
                'label'=>'Lieu Hotel',
                'attr'=>[
                    'placeholder'=> 'Merci de définir le lieu',
                    'class'=>'lieu'
                ]
            ])
            ->add('chambre')
            ->add('etoile')
            ->add('hebergement')
            ->add('nom')
            ->add('path')
            ->add('pathVideo')
            ->add('prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}
