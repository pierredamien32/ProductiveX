<?php

namespace App\Form;

use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control validate',
                    'minlength' => '3',
                    'maxlength' => '50'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 3, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('duree', DateIntervalType::class,[
                // 'input'    => 'string',
                // 'widget'      => 'integer', 
                'attr' => [
                    'class' => 'form-select ',
                ],
                'label' => 'Durée en mois',
                'label_attr' => [
                    'class' => 'form-label '
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'form-control validate',
                    'minlength' => '2',
                ],
                'label' => 'Description du projet',
                'label_attr' => [
                    'class' => 'form-label '
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2]),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'créer'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}