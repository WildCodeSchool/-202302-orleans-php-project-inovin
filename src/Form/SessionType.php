<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Wine;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options): void
    {
        $formBuilder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Intitulé',
                    'attr' => [
                        'placeholder' => 'Intitulé de la séance...',
                    ],
                    'label_attr' => [
                        'class' => 'form-label text-uppercase letter-spacing mb-2'
                    ],
                ]
            )

            ->add(
                'openingDate',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'label' => 'Date d\'ouverture',
                    'attr' => [
                        'class' => 'form-control border border-secondary',
                    ],
                    'label_attr' => [
                        'class' => 'form-label text-uppercase letter-spacing mb-2'
                    ],
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Description',
                    'attr' => [
                        'placeholder' => 'Descriptif de la séance...',
                    ],
                    'label_attr' => [
                        'class' => 'form-label text-uppercase letter-spacing mb-2'
                    ],
                ]
            )
            ->add(
                'closed',
                CheckboxType::class,
                [
                    'label' => 'Terminée ?',
                    'required' => false,
                    'label_attr' => [
                        'class' => 'form-check-label text-uppercase letter-spacing mb-2'
                    ],
                    'attr' => [
                        'class' => 'form-check-input fs-5',
                        'role' => "switch"
                    ],
                    'row_attr' => ['class' => "form-check form-switch"],
                ],
            )
            ->add(
                'wines',
                EntityType::class,
                [
                    'label' => 'Choix des vins pour cette séance',
                    'class' => Wine::class,
                    'choice_label' => 'FullLabel',
                    'query_builder' => function (WineRepository $er): QueryBuilder {
                        return $er->createQueryBuilder('w')
                            ->where('w.enabled = 1')
                            ->orderBy('w.name', 'ASC')
                            ->addOrderBy('w.year', 'ASC');
                    },
                    'label_attr' => [
                        'class' => 'form-label text-uppercase letter-spacing mb-2'
                    ],
                    'multiple' => true,
                    'expanded' => true,
                    'attr' => [
                        'class' => 'form-control border border-secondary rounded-1 max-height-select',
                    ],
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
