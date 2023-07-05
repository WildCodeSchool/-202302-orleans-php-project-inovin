<?php

namespace App\Form;

use App\Entity\UserQuiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class QuizWineColourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'options',
                ChoiceType::class,
                [
                    'label' => 'Tu préfères :',
                    'label_attr' =>
                        [
                            'class' => 'form-label color-primary text-uppercase letter-spacing mb-5'
                        ],
                    'choices' => [
                        'Le vin rouge' => 'Le vin rouge',
                        'Le vin blanc' => 'Le vin blanc',
                        'Le vin rosé' => 'Le vin rosé',
                    ],
                    'multiple' => false,
                    'expanded' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserQuiz::class,
        ]);
    }
}
