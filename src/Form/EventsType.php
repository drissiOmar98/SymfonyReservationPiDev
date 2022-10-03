<?php

namespace App\Form;

use App\Entity\Events;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class EventsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class)
            ->add('period')
            ->add('location')
            ->add('date')
            ->add('available')
            ->add('prix')
            ->add('imageFile',VichImageType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Events::class,
        ]);
    }

}
