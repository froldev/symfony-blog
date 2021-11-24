<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("title", TextType::class, [
                "attr" => [
                    "placeholder" => "Titre de l'article",
                ]
            ])
            ->add("content", TextareaType::class, [
                "attr" => [
                    "placeholder" => "Contenu de l'article",
                ]
            ])
            ->add('image', TextType::class, [
                "attr" => [
                    "placeholder" => "URL de l'image",
                ]
            ])
            ->remove('createdAt')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
