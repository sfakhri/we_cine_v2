<?php

declare(strict_types=1);

namespace App\Form;

use App\Enum\GenderEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchMovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('query', TextType::class, [
                'label' => 'Titre du film',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Film',
                ],
            ])
            ->add('categories', ChoiceType::class, [
                'label' => 'Catégories',
                'choices' => $this->getCategories(),
                'placeholder' => 'Sélectionnez des catégories',
                'required' => false,
                'multiple' => true,
                'expanded' => false,
            ]);
    }

    /**
     * @return array<string, int>
     */
    private function getCategories(): array
    {
        $categories = [];
        foreach (GenderEnum::cases() as $category) {
            $categories[$category->name] = $category->value;
        }

        return $categories;
    }

    public function getBlockPrefix(): string
    {
        return 'search_movie';
    }
}
