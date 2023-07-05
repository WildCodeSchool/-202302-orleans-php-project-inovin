<?php

namespace App\Form;

use App\Entity\TastingSheet;
use App\Entity\Wine;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                ],
                'label' => 'Goût',
            ])
            ->add('smell', RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 10,
                ],
                'label' => 'Odeur',
            ])
            ->add('visual', RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 10,
                ],
                'label' => 'Visuel',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TastingSheet::class,
        ]);
    }
}
