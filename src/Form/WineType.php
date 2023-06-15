<?php

namespace App\Form;

use App\Entity\Wine;
use App\Entity\GrapeVariety;
use Symfony\Component\Form\AbstractType;
use App\Repository\GrapeVarietyRepository;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                    'label' => 'l\'année de mise en bouteille',
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
                    'label' => 'Pourcentage d\'alcool',
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
                    'label' => 'Le prix',
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
                    'by_reference' => false,
                ]
            )

            ->add('wineFile', VichFileType::class, [

                'required'      => false,

                'allow_delete'  => true, // not mandatory, default is true

                'download_uri' => true, // not mandatory, default is true

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wine::class,
        ]);
    }
}
