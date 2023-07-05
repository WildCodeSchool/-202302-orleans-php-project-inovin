<?php

namespace App\Form;

use App\Entity\UserQuiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuizKnowledgeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'options',
                ChoiceType::class,
                [
                    'label' => 'Tu es plutôt :',
                    'label_attr' =>
                    [
                        'class' => 'form-label color-primary text-uppercase letter-spacing mb-5'
                    ],
                    'choices' => [
                        'Un amateur de vin désireux de découvrir et d’apprendre' => 'Amateur',
                        'Un bon connaisseur pour qui le vin n’a pas de secrets' => 'Connaisseur',
                        'Un véritable oenologue' => 'Oenologue',
                    ],
                    'multiple' => true,
                    'expanded' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserQuiz::class,
        ]);
    }
}
