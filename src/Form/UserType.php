<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control rounded-0 bg-transparent p-0',
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing text-primary-light',
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control rounded-0 bg-transparent p-0',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing text-primary-light'
                ],
            ])
            ->add('date_birth', BirthdayType::class, [
                'attr' => [
                    'required' => false,
                    'placeholder' => 'JJ-MM-YYYY',
                    'class' => 'form-control rounded-0 bg-transparent p-0',
                ],
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing text-primary-light'
                ],
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse complète',
                    'class' => 'form-control rounded-0 bg-transparent p-0',
                ],
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing text-primary-light'
                ],
            ])
            ->add('zip_code', TextType::class, [
                'attr' => [
                    'class' => 'form-control rounded-0 bg-transparent p-0',
                ],
                'label' => 'Code postal',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing text-primary-light',
                ],
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control rounded-0 bg-transparent p-0',
                ],
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing text-primary-light'
                ],
            ])
            ->add('country', TextType::class, [
                'attr' => [
                    'class' => 'form-control rounded-0 bg-transparent p-0',
                ],
                'label' => 'Pays',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing text-primary-light'
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control rounded-0 bg-transparent p-0',
                ],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing text-primary-light'
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => false,
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'style' => 'display: none;',
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
