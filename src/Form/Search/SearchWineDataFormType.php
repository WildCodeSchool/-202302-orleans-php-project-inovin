<?php

namespace App\Form\Search;

use App\Entity\GrapeVariety;
use App\Search\SearchWineData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('Reset', ResetType::class, [
                'attr' => [
                    'class' => 'btn btn-sm text-uppercase text-decoration-none',
                ]
            ])
            ->add('name', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher un vin',
                    'class' => 'form-control border border-secondary placeholder-style my-3',
                ]
            ])
            ->add('grapeVarieties', EntityType::class, [
                'label' => 'Cépages',
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mb-2'
                ],
                'required' => false,
                'class' => GrapeVariety::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'attr' => [
                    'class' => 'form-control grid gap-2 fs-6 border p-2 m-1 
                    rounded-2 border-secondary max-height-select my-3',
                ]
            ])
            ->add('maxPrice', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix maximum',
                    'class' => 'form-control border border-secondary ',
                ]
            ])
            ->add('minPrice', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix minimum',
                    'class' => 'form-control border border-secondary text-end',
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
