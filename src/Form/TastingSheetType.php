<?php

namespace App\Form;

use App\Entity\TastingSheet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TastingSheetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('taste', RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 10,
                    'class' => 'mt-5 px-5 form-range',
                    'type' => "range",
                    'value' => 5,
                    'oninput' => "this.nextElementSibling.value = this.value",
                ],
                'label' => false,
            ])
            ->add('smell', RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 10,
                    'class' => 'mt-5 px-5 custom-range',
                    'type' => "range",
                    'value' => 5,
                    'oninput' => "this.nextElementSibling.value = this.value",
                ],
                'label' => false,
            ])
            ->add('visual', RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 10,
                    'class' => 'mt-5 px-5 custom-range',
                    'type' => "range",
                    'value' => 5,
                    'oninput' => "this.nextElementSibling.value = this.value",
                ],
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TastingSheet::class,
        ]);
    }
}
