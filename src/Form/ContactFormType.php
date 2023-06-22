<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Veuillez écrire votre nom'],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Veuillez écrire votre prénom'],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Veuillez écrire votre email'],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
            ])
            ->add('phone', TelType::class, [
                'required' => false,
                'label' => 'Téléphone',
                'attr' => ['placeholder' => 'Veuillez écrire votre numéro'],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
                'attr' => ['placeholder' => 'Veuillez renseigner un sujet'],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'placeholder' => 'Veuillez écrire votre message',
                    'class' => 'message'
                ],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
