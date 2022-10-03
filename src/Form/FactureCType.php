<?php

namespace App\Form;

use App\Entity\Banque;
use App\Entity\FacturesClients;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureCType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomClient')
            ->add('banque',EntityType::class,[
                'class'=>Banque::class,
                'choice_label'=>'nomBanque'
            ])
            ->add('dateFac')
            ->add('reglementFac')
            ->add('etatFac')
            ->add('tvaFac')
            ->add('remiseFac')
            ->add('nbFac')
            ->add('totaleFac')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FacturesClients::class,
        ]);
    }
}
