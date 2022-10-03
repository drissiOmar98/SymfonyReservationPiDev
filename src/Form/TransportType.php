<?php

namespace App\Form;

use App\Entity\Transport;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use function PHPSTORM_META\type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('date')
            ->add('apartir')
            ->add('vers')
            ->add('driver')
            ->add('prix')
            ->add('path')
            ->add('availability')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transport::class,
        ]);
    }
}
