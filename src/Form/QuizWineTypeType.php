<?php

namespace App\Form;

use App\Entity\UserQuiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuizWineTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'options',
                ChoiceType::class,
                [
                    'label' => 'Au palais, c\'est plus :',
                    'label_attr' =>
                        [
                            'class' => 'form-label color-primary text-uppercase letter-spacing mb-5'
                        ],
                    'choices' => [
                        'Sec' => 'Sec',
                        'Demi-sec' => 'Demi-sec',
                        'Moelleux' => 'Moelleux',
                        'Liquoreux' => 'Liquoreux',
                        'Pétillant' => 'Pétillant',
                        'Tranquille' => 'Tranquille,'
                    ],
                    'multiple' => true,
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
