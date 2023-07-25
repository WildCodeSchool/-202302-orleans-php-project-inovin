<?php

namespace App\Form;

use App\Entity\User;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

/** @SuppressWarnings(PHPMD.ExcessiveMethodLength) */
class RegistrationFormType extends AbstractType
{
    public const AGE_LIMIT = " - 18 years";

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $today = date('d-M-y');
        $limitAge = date('d-M-y', strtotime($today . self::AGE_LIMIT));

        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control border border-secondary placeholder-style',
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing'
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control border border-secondary placeholder-style',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing'
                ],
            ])
            ->add('dateBirth', BirthdayType::class, [
                'attr' => [
                    'required' => false,
                    'placeholder' => 'JJ-MM-YYYY',
                    'class' => 'form-control border border-secondary placeholder-style w-100',
                ],
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing'
                ],
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'd-M-y',
                'constraints' => [
                    new LessThanOrEqual([
                        'value' => $limitAge,
                        'message' => 'Vous devez être majeur pour vous inscrire'
                    ]),
                    new LessThanOrEqual([
                        'value' => $today,
                        'message' => 'Veuillez selectionner une date valide'
                    ])
                ]
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse complète',
                    'class' => 'form-control border border-secondary placeholder-style',
                ],
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing'
                ],
            ])
            ->add('zipCode', TextType::class, [
                'attr' => [
                    'class' => 'form-control border border-secondary placeholder-style',
                ],
                'label' => 'Code postal',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing',
                ],
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control border border-secondary placeholder-style',
                ],
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing'
                ],
            ])
            ->add('country', TextType::class, [
                'attr' => [
                    'class' => 'form-control border border-secondary placeholder-style',
                ],
                'label' => 'Pays',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing'
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control border border-secondary placeholder-style',
                ],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing'
                ],
            ])
            ->add('password', PasswordType::class, [
                'always_empty' => false,
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control border border-secondary placeholder-style'
                ],
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing'
                ],
                'constraints' => [
                    new NotBlank(), new Length(['min' => 6, 'max' => 50]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
