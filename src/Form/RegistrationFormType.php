<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control border border-secondary placeholder-style',
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control border border-secondary placeholder-style',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
            ])
            ->add('date_birth', BirthdayType::class, [
                'attr' => [
                    'placeholder' => 'JJ-MM-YYYY',
                    'class' => 'form-control border border-secondary placeholder-style w-100',
                ],
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-1'
                ],
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse complète',
                    'class' => 'form-control border border-secondary mb-3 placeholder-style',
                ],
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
            ])
            ->add('zip_code', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control border border-secondary placeholder-style',
                ],
                'label' => 'Code postal',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2',
                ],
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control border border-secondary placeholder-style',
                ],
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
            ])
            ->add('country', TextType::class, [
                'attr' => [
                    'class' => 'form-control border border-secondary placeholder-style',
                ],
                'label' => 'Pays',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control border border-secondary mb-3 placeholder-style',
                ],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control border border-secondary mb-3 placeholder-style'
                ],
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 6, 'max' => 4096]),
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
