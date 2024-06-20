<?php

// src/Form/RecetteType.php

namespace App\Form;

use App\Entity\Ingredients;
use App\Entity\Recette;
use App\Entity\Tags;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TypeTextType::class, [
                'attr' => ['class' => 'inpTitre']
            ])
            ->add('etapes', TextareaType::class, [
                'attr' => ['class' => 'inpEtapes']
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredients::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'attr' => [
                    'class' => 'select2',
                    'data-placeholder' => 'Sélectionnez ou recherchez un ingrédient'
                ],
            ])
            ->add('tags', EntityType::class, [
                'class' => Tags::class,
                'choice_label' => 'titre',
                'multiple' => true,
                'attr' => [
                    'class' => 'select2',
                    'data-placeholder' => 'Sélectionnez ou recherchez un tag'
                ],
            ])
            ->add('quantities', CollectionType::class, [
                'entry_type' => QuantityItemType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
