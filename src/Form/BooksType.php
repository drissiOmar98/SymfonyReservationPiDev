<?php

namespace App\Form;

use App\Entity\Books;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipement',TextType::class,[
                'label'=>' Nom Equipement',
                'attr'=>[
                    'novalidate' => 'novalidate',
                    'placeholder'=>'merci de définir le nom',
                    'class'=>'name'
                ]
            ])
            ->add('code',TextType::class)
            ->add('etat',TextType::class)
            ->add('employe',TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
