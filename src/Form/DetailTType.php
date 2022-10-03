<?php

namespace App\Form;

use App\Entity\DetailT;
use App\Entity\Transport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailTType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque')
            ->add('etat')
            ->add('prix')

            ->add('transport', EntityType::class, [
                'class' => Transport::class,

                'choice_label'=> 'id'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DetailT::class,
        ]);
    }
}
