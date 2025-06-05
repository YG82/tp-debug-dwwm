<?php

namespace App\Form;

use App\Entity\Todo;
use App\Form\TaskFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TodoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Choisissez un nom pour votre liste',
                'attr' => [
                    'placeholder' => 'Nom de la liste',
                ],
            ])
            ->add('is_public', CheckboxType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Divers' => 'divers',
                    'Courses' => 'courses', 
                    'Administratif' => 'administratif', 
                    'Factures' => 'factures', 
                    'Sorties' => 'sorties', 
                    'Anniversaire' => 'anniversaire', 
                    'Urgent' => 'urgent', 
                    'Ménage' => 'menage', 
                    'Déménagement' => 'demenagement',
                    'Business' => 'business',
                    'Travail' => 'travail',
                    'Voyage' => 'voyage',
                    'Sport' => 'sport',
                    'Santé' => 'sante',
                    'Rendez-vous' => 'rdv',
                    'Culture' => 'culture',
                ],
                'label' => 'Choisissez une catégorie',
                'placeholder' => 'Sélectionnez une catégorie',
            ])
            ->add('tasks', CollectionType::class, [
                'entry_type' => TaskFormType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'label' => false,
                'attr' => [
                    'class' => 'task-collection',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => '',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Todo::class,
        ]);
    }
}