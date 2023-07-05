<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\TastingSheet;
use App\Form\TastingSheetType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeTastingSheetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('tastingSheet', CollectionType::class, [
                'label' => false,
                'entry_type' => TastingSheetType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'allow_extra_fields' => true,
                'entry_options' => [
                    'label' => false,
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
