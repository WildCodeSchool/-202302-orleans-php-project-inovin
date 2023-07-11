<?php

namespace App\Form;

use App\Entity\TastingSheet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeDosageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dosage', RangeType::class, [
                'attr' => [
                    'required' => false,
                    'min' => 0,
                    'max' => 150,
                    'class' => 'form-range',
                    'type' => "range",
                    'oninput' => "this.nextElementSibling.value = this.value",
                    'step' => 25,
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
