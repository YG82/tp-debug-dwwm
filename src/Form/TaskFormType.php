<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TaskFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Décrivez la tâche à réaliser',
                'attr' => [
                    'rows' => 2,
                    'placeholder' => 'Exemple : Acheter du pain sans gluten 🤷',
                ],
            ])
            ->add('time_due', DateTimeType::class, [
                'label' => 'À faire avant le',
                'widget' => 'single_text',
                'required' => false,
                'attr' => [
                    'value' => (new \DateTime())->format('Y-m-d H:i'),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
