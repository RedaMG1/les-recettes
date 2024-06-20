<?php 

// src/Form/QuantityItemType.php

// src/Form/QuantityItemType.php

namespace App\Form;

use App\Entity\Ingredients;
use App\Entity\Quantity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuantityItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('qte', NumberType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Quantity'
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredients::class,
                'choice_label' => 'nom',
                
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Ingredient',
                'disabled' => true, // Disable this field to prevent changes
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quantity::class,
        ]);
    }
}



