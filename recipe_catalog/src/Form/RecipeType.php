<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('title', null, [
                'label' => 'Название рецепта',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Описание',
            ])
            ->add('ingredients', TextareaType::class, [
                'label' => 'Ингредиенты',
            ])
            ->add('instructions', TextareaType::class, [
                'label' => 'Способ приготовления',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Категория',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить рецепт',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
