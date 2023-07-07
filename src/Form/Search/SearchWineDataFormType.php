<?php

namespace App\Form\Search;

use App\Form\Search\GrapeVarietiesAutocompleteField;
use App\Search\SearchWineData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchWineDataFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher un vin',
                    'class' => 'form-control border border-secondary placeholder-style my-3',
                ]
            ])
            ->add('grapeVarieties', GrapeVarietiesAutocompleteField::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Quel cépage ?',
                    'class' => 'form-control border border-secondary placeholder-style my-3',
                ]
            ])
            ->add('maxPrice', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'invisible',
                ]
            ])
            ->add('minPrice', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'invisible h',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchWineData::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
