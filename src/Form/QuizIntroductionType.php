<?php

namespace App\Form;

use App\Entity\UserPreference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuizIntroductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'wineKnowledge',
                ChoiceType::class,
                [
                    'label' => 'Tu es plutôt :',
                    'label_attr' =>
                    [
                        'class' => 'form-label color-primary text-uppercase letter-spacing mb-3'
                    ],
                    'choices' => [
                        'Un amateur de vin désireux de découvrir et d’apprendre' => 'Amateur',
                        'Un bon connaisseur pour qui le vin n’a pas de secrets' => 'Connaisseur',
                        'Un véritable oenologue' => 'Oenologue',
                    ],
                    'multiple' => false,
                    'expanded' => true,
                ]
            )
            ->add(
                'wineColour',
                ChoiceType::class,
                [
                    'label' => 'Tu préfères :',
                    'label_attr' =>
                        [
                            'class' => 'form-label color-primary text-uppercase letter-spacing mb-3'
                        ],
                    'choices' => [
                        'Le vin rouge' => 'Le vin rouge',
                        'Le vin blanc' => 'Le vin blanc',
                        'Le vin rosé' => 'Le vin rosé',
                    ],
                    'multiple' => false,
                    'expanded' => true,
                ]
            )
            ->add(
                'wineType',
                ChoiceType::class,
                [
                    'label' => 'Au palais, c\'est plus :',
                    'label_attr' =>
                        [
                            'class' => 'form-label color-primary text-uppercase letter-spacing mb-3'
                        ],
                    'choices' => [
                        'Sec' => 'Sec',
                        'Demi-sec' => 'Demi-sec',
                        'Moelleux' => 'Moelleux',
                        'Liquoreux' => 'Liquoreux',
                        'Pétillant' => 'Pétillant',
                        'Tranquille' => 'Tranquille,'
                    ],
                    'multiple' => false,
                    'expanded' => true,
                ]
            )
            ->add(
                'wineRegion',
                ChoiceType::class,
                [
                    'label' => 'Côté terroir :',
                    'label_attr' =>
                        [
                            'class' => 'form-label color-primary text-uppercase letter-spacing mb-3'
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
                    'multiple' => false,
                    'expanded' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserPreference::class,
        ]);
    }
}
