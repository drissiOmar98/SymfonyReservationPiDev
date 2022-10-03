<?php

namespace App\Form;

use App\Entity\Offre;
use App\Entity\Saisonoffre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaisonoffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idsaison')
            ->add('idoffre',EntityType::class,['class'=>Offre::class, 'choice_label'=>'titre'])
            ->add('titresaison')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Saisonoffre::class,
        ]);
    }
}
