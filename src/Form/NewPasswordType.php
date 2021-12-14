<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class NewPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'currentPassword',
                PasswordType::class,
                [
                    'label' => 'Mot de passe actuel',
                    'attr' => [
                        'class' => 'input'
                    ],
                    'constraints' => [
                        new UserPassword([
                            'message' => 'Ne correspond pas a votre mot de passe actuel'
                        ])
                    ]
                ]
            )
            ->add(
                'newPassword',
                RepeatedType::class,
                [
                    'mapped' => false,
                    'type' => PasswordType::class,
                    'required' => true,
                    'options' => [
                        'attr' => [
                            'class' => 'input'
                        ]
                    ],
                    'first_options'  => [
                        'label' => 'Nouveau mot de passe'
                    ],
                    'second_options' => [
                        'label' => 'Vérifier le nouveau mot de passe'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Choisisez un mot de passe !'
                        ]),
                        new Length([
                            'min' => 5,
                            'minMessage' => 'Doit être supérieur à 5 caractères'
                        ])
                    ],

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
