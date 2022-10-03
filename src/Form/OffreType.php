<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('nom')
            ->add('dateValidite')
            ->add('tauxDeRemise')
            ->add('description')
            ->add('path',FileType::class, array('data_class' => null))
            ->add('pathVideo')
            ->add('prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
