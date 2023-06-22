<?php

namespace App\Form;

use App\Form\UserType;
use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sigle', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ex: ESGIS',
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Sigle',
                'label_attr' => [
                    'class' => 'form-label '
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('denomination', TextType::class, [
                'attr' => [
                    'placeholder' => "Ex: Ecole Supérieure de Gestion, d'Informatique et des Sciences",
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'label' => 'Denomination Social',
                'label_attr' => [
                    'class' => 'form-label '
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'placeholder' => "Ex:  Boulevard de l'Ouémé Jéricho, Cotonou, Benin",
                    'class' => 'form-control',
                    'minlength' => '2',
                ],
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'form-label'
                ],
            ])
            ->add('logo', FileType::class, [
                'required'   => false,
                'label' => 'Image',
                'attr' => [
                    'class' => 'form-control'
                ], 
                'label_attr' => [   
                'class' => 'form-label'
            ],
                // 'constraints' => [
                //     new Assert\File([
                //         'maxSize' => '5M',
                //     ]),
                // ],
            ])
            ->add('user', UserType::class, [
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}