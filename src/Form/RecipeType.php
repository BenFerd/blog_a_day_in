<?php

namespace App\Form;

use App\Entity\Recipes;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la recette : ',
                'attr' => ['placeholder' => 'Tapez le nom de la catégorie']
            ])
            ->add('quantities', TextType::class, [
                'label' => 'Nombre de personnes : ',
                'attr' => ['placeholder' => 'Tapez le nom de la catégorie']
            ])
            ->add('time', TextType::class, [
                'label' => 'Temps de préparation : ',
                'attr' => ['placeholder' => 'Tapez le temps de préparation']
            ])
            ->add('image', UrlType::class, [
                'label' => 'Image : ',
                'attr' => ['placeholder' => 'Tapez l\'url de l\'image']
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'placeholder' => '-- Choisir une catégorie --',
                'class' => Category::class,
                'choice_label' => function (Category $category) {
                    return strtoupper($category->getName());
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipes::class,
        ]);
    }
}
