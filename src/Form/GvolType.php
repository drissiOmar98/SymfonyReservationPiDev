<?php

namespace App\Form;

use App\Entity\Vol;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GvolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dated')
            ->add('apartir')
            ->add('vers')
            ->add('chauffeur')
            ->add('prix')
            ->add('path')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
