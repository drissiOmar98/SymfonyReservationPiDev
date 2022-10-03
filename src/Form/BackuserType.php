<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class BackuserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
            ->add('prenom',TextType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
            ->add('email',EmailType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
            ->add('roles',choiceType::class, [
                'attr' => array('class' => 'form-control'),
                'choices' =>[
                    'Admin'=>'ROLE_ADMIN',
                    'USER1'=>'ROLE_USER',
                    'USER2'=>'ROLE_USER',
                    'USER3'=>'ROLE_USER',
                    'USER4'=>'ROLE_USER',
                    'USER5'=>'ROLE_USER',
                    'USER6'=>'ROLE_USER',



                ],

                'multiple'=>true,
                'label'=>'roles'
            ])
            ->add('cin',TextType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
            ->add('password',PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => array('class' => 'form-control'),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,

                    ]),
                ],
            ])
            ->add('imageFile', FileType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
