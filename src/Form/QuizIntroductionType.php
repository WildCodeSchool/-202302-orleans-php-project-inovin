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
                    'label' => 'TU ES PLUTÔT ?',
                    'choices' => [
                        'Un amateur de vin désireux de découvrir et d’apprendre' => 'Amateur',
                        'Un bon connaisseur pour qui le vin n’a pas de secrets' => 'Connaisseur',
                        'Un véritable oenologue' => 'Oenologue',
                    ],
                    'attr' => [
                        'class' => 'my-custom-radio color-primary letter-spacing mb-3',
                    ],
                    'multiple' => false,
                    'expanded' => true,
                ]
            )
            ->add(
                'wineColour',
                ChoiceType::class,
                [
                    'label' => 'TU PRÉFÈRES ?',
                    'choices' => [
                        'Le vin rouge' => 'Le vin rouge',
                        'Le vin blanc' => 'Le vin blanc',
                        'Le vin rosé' => 'Le vin rosé',
                    ],
                    'attr' => [
                        'class' => 'my-custom-radio color-primary letter-spacing mb-3',
                    ],
                    'multiple' => false,
                    'expanded' => true,
                ]
            )
            ->add(
                'wineType',
                ChoiceType::class,
                [
                    'label' => 'AU PALAIS? C\'EST PLUS ?',
                    'choices' => [
                        'Sec' => 'Sec',
                        'Demi-sec' => 'Demi-sec',
                        'Moelleux' => 'Moelleux',
                        'Liquoreux' => 'Liquoreux',
                        'Pétillant' => 'Pétillant',
                        'Tranquille' => 'Tranquille'
                    ],
                    'attr' => [
                        'class' => 'my-custom-radio color-primary letter-spacing mb-3',
                    ],
                    'multiple' => false,
                    'expanded' => true,
                ]
            )
            ->add(
                'wineRegion',
                ChoiceType::class,
                [
                    'label' => 'CÔTÉ TERROIR ?',
                    'choices' => [
                        'Alsace' => 'Alsace',
                        'Beaujolais' => 'Beaujolais',
                        'Bordeaux' => 'Bordeaux',
                        'Bourgogne' => 'Bourgogne',
                        'Champagne' => 'Champagne',
                        'Jura' => 'Jura',
                        'Languedoc-Roussillon' => 'Languedoc-Roussillon',
                        'Provence' => 'Provence',
                        'Savoie' => 'Savoie',
                        'Sud-Ouest' => 'Sud-Ouest',
                        'Vallée de la Loire' => 'Vallée de la Loire',
                        'Vallée du Rhône' => 'Vallée du Rhône',
                    ],
                    'attr' => [
                        'class' => 'my-custom-radio color-primary letter-spacing mb-3',
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
