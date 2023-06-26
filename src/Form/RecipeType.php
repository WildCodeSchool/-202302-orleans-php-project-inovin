<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Session;
use Doctrine\DBAL\Types\TextType;
use App\Repository\UserRepository;
use App\Repository\SessionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom de la recette',
                    'attr' => [
                        'placeholder' => 'Thomas',
                    ],
                ]
            )
            ->add(
                'session_rate',
                NumberType::class,
                [
                    'label' => 'Note de la recette',
                    'attr' => [
                        'placeholder' => '14',
                    ],
                ]
            )
            ->add(
                'session',
                EntityType::class,
                [
                    'class' => Session::class,
                    'query_builder' => function (SessionRepository $sr) {
                        return $sr->createQueryBuilder('s')
                            ->orderBy('s.name', 'ASC');
                    },
                    'choice_label' => 'name',
                    'by_reference' => true,
                ]
            )
            ->add(
                'user',
                EntityType::class,
                [
                    'class' => User::class,
                    'query_builder' => function (UserRepository $ur) {
                        return $ur->createQueryBuilder('u')
                            ->orderBy('u.firstname', 'ASC');
                    },
                    'choice_label' => 'firstname',
                    'by_reference' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
