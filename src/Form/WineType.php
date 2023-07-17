<?php

namespace App\Form;

use App\Entity\Wine;
use App\Entity\WineTaste;
use App\Entity\WineRegion;
use App\Entity\GrapeVariety;
use App\Repository\WineTasteRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\GrapeVarietyRepository;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class WineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom du vin',
                    'attr' => [
                        'placeholder' => 'Chateau Angelus...',
                    ],
                ]
            )
            ->add(
                'year',
                IntegerType::class,
                [
                    'label' => 'Année de mise en bouteille',
                    'attr' => [
                        'placeholder' => '2000',
                    ],
                ]
            )
            ->add(
                'volume',
                NumberType::class,
                [
                    'label' => 'Volume de la bouteille',
                    'attr' => [
                        'placeholder' => '1,5'
                    ]
                ]
            )
            ->add(
                'alcoholPercent',
                NumberType::class,
                [
                    'label' => 'Volume d\'alcool (%)',
                    'scale' => 1,
                    'attr' => [
                        'placeholder' => '12'
                    ]
                ]
            )
            ->add(
                'price',
                numberType::class,
                [
                    'label' => 'Prix (€)',
                    'scale' => 3,
                    'attr' => [
                        'placeholder' => '60',
                    ]
                ]
            )
            ->add(
                'grapeVariety',
                EntityType::class,
                [
                    'class' => GrapeVariety::class,
                    'query_builder' => function (GrapeVarietyRepository $er) {
                        return $er->createQueryBuilder('g')
                            ->orderBy('g.name', 'ASC');
                    },
                    'choice_label' => 'name',
                    'by_reference' => true,
                ]
            )
            ->add(
                'wineTaste',
                EntityType::class,
                [
                    'class' => WineTaste::class,
                    'choice_label' => 'tasteName',
                ]
            )
            ->add(
                'wineRegion',
                EntityType::class,
                [
                    'class' => WineRegion::class,
                    'choice_label' => 'regionName',
                ]
            )
            ->add('wineFile', VichFileType::class, [

                'required'      => false,

                'allow_delete'  => false, // not mandatory, default is true

                'download_uri' => false, // not mandatory, default is true

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wine::class,
        ]);
    }
}
