<?php

namespace App\Form;

use App\Entity\Tache;
use App\Entity\Projet;
use App\Entity\Employe;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;

class TacheType extends AbstractType
{

    // private $entreprise;

    // public function __construct($entreprise)
    // {
    //     $this->entreprise = $entreprise;
    // }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control validate',
                    'minlength' => '3',
                    'maxlength' => '50'
                ],
                'label' => 'Nom de la tache',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 3, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('duree', DateIntervalType::class, [
                // 'input'    => 'string',
                // 'widget'      => 'integer', 
                'attr' => [
                    'class' => 'form-select ',
                ],
                'label' => 'Durée ',
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
                    'maxlength' => '50'
                ],
                'label' => 'Description de la tâche',
                'label_attr' => [
                    'class' => 'form-label '
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                ]
            ])
            ->add('projet', EntityType::class, [
                'class' => 'App\Entity\Projet', // Remplacez par le chemin de votre entité Projet
                'choice_label' => 'nom', // Le champ à afficher dans la liste déroulante
                'required' => true, // Facultatif, pour rendre le champ obligatoire
                'query_builder' => function (EntityRepository $er) use ($options)  {
                    return $er->createQueryBuilder('p')
                        ->andWhere('p.entreprise = :entreprise')
                        ->setParameter('entreprise', $options['entreprise']);
                },
                'label' => 'Projet associé ',
                'label_attr' => [
                    'class' => 'form-label '
                ],
                ])
            ->add('employe', EntityType::class, [
                'class' => 'App\Entity\Employe', // Remplacez par le chemin de votre entité Projet
                'choice_label' => 'nom', // Le champ à afficher dans la liste déroulante
                'required' => true, // Facultatif, pour rendre le champ obligatoire
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('p')
                        ->andWhere('p.entreprise = :entreprise')
                        ->setParameter('entreprise', $options['entreprise']);
                },
                'label' => 'Employé assigné ',
                'label_attr' => [
                    'class' => 'form-label '
                ],
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
            'entreprise' => null,
            'data_class' => Tache::class,
        ]);
    }
}