<?php

namespace App\Form\Search;

use App\Entity\GrapeVariety;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class GrapeVarietiesAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => GrapeVariety::class,
            'label' => 'Quel cépage ?',
            'choice_label' => 'name',
            'multiple' => true,
            /*
            'constraints' => [
                new Count(min: 1, minMessage: 'We need to eat *something*'),
            ],
            */
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
