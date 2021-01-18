<?php

namespace App\Form;

use App\Entity\Unity;
use App\Entity\Ingredients;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'ingrédient : ',
                'attr' => ['placeholder' => 'Safran']
            ])
            ->add('unity', EntityType::class, [
                'label' => 'Unité',
                'placeholder' => '-- Choisir une unité --',
                'class' => Unity::class,
                'choice_label' => function (Unity $unity) {
                    return $unity->getShortName();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ingredients::class,
        ]);
    }
}
