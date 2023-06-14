<?php

namespace App\Form;

use App\Entity\GrapeColor;
use App\Entity\GrapeVariety;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrapeVarietyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom du cépage',
                    'attr' => [
                        'placeholder' => 'Cabernet franc...',
                    ],
                ]
            )
            ->add(
                'color',
                EntityType::class,
                [
                    'label' => 'Couleur',
                    'class' => GrapeColor::class,
                    'choice_label' => 'color',
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GrapeVariety::class,
        ]);
    }
}
