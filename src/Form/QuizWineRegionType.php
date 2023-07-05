<?php

namespace App\Form;

use App\Entity\UserQuiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuizWineRegionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'options',
                ChoiceType::class,
                [
                    'label' => 'Côté terroir :',
                    'label_attr' =>
                        [
                            'class' => 'form-label color-primary text-uppercase letter-spacing mb-5'
                        ],
                    'choices' => [
                        'Alsace' => 'Alsace',
                        'Beaujolais' => 'Beaujolais',
                        'Bordeaux' => 'Bordeaux',
                        'Champagne' => 'Champagne',
                        'Jura' => 'Jura',
                        'Languedoc-Roussillon' => 'Languedoc-Roussillon',
                        'Provence' => 'Provence',
                        'Savoie' => 'Savoie',
                        'Sud-Ouest' => 'Sud-Ouest',
                        'Vallée de la Loire' => 'Vallée de la Loire',
                        'Vallée du Rhône' => 'Vallée du Rhône',
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
