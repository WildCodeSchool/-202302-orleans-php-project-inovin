<?php

namespace App\Form;

use App\Entity\GrapeVariety;
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
                    'row_attr' => [
                        'class' => 'row mb-3 w-100 p-0 m-0',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GrapeVariety::class,
        ]);
    }
}
