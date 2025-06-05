<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une adresse email',
                    ]),
                    new Length([
                        'max' => 180,
                        'maxMessage' => 'L\'adresse email ne doit pas dépasser {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('username', TextType::class, [
                'label' => 'Choisissez un nom d\'utilisateur',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom d\'utilisateur',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le nom d\'utilisateur doit contenir au moins {{ limit }} caractères',
                        'max' => 30,
                        'maxMessage' => 'Le nom d\'utilisateur ne doit pas dépasser {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9_]+$/',
                        'message' => 'Le nom d\'utilisateur ne doit contenir que des lettres, des chiffres et des underscores',
                    ]),
                ],
            ])
            ->add('is_major', CheckboxType::class, [
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez être majeur pour vous inscrire',
                    ]),
                ],
            ])
            ->add('is_terms', CheckboxType::class, [
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions d\'utilisation',
                    ]),
                ],
            ])
            ->add('is_gpdr', CheckboxType::class, [
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter la politique de confidentialité',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'hidden_label' => '',
                    'visible_label' => '',
                    'toggle' => true,
                    'visible_icon' => '🙈',
                    'hidden_icon' => '🐵',
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'hidden_label' => '',
                    'visible_label' => '',
                    'toggle' => true,
                    'visible_icon' => '🙈',
                    'hidden_icon' => '🐵',
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et un chiffre',
                    ])
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
