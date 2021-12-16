<?php

namespace App\Form;

use App\Entity\Peinture;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeintureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'input'
                ]
            ])
            ->add('matiere', TextType::class, [
                'label' => 'Essence de bois',
                'attr' => [
                    'class' => 'input'
                ]
            ])
            ->add('hauteur', NumberType::class, [
                'label' => 'Hauteur en cm',
                'attr' => [
                    'class' => 'input'
                ]
            ])
            ->add('largeur', NumberType::class, [
                'label' => 'Largeur en cm',
                'attr' => [
                    'class' => 'input'
                ]
            ])
            ->add('profondeur', NumberType::class, [
                'label' => 'Profondeur en cm',
                'attr' => [
                    'class' => 'input'
                ]
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Prix en ',
                'required' => false,
                'divisor' => 100,
                'attr' => [
                    'class' => 'input'
                ]
            ])
            ->add('enVente', CheckboxType::class, [
                'label' => 'En vente',
                'label_attr' => [
                    'class' => 'is-pulled-right'
                ],
                'required' => false,
                'attr' => [
                    'class' => 'checkbox mr-2',
                    'checked' => false
                ]
            ])
            ->add('dateRealisation', DateType::class, [
                'label' => 'Date de fabrication',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input',
                ]
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'textarea'
                ]
            ])
            ->add('images', FileType::class, [
                'label' => 'Photos 360',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'input'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Peinture::class,
        ]);
    }
}
