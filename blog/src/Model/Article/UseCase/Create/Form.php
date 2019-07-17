<?php

declare(strict_types=1);

namespace App\Model\Article\UseCase\Create;

use App\ReadModel\Author\AuthorFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private $authors;

    public function __construct(AuthorFetcher $authors)
    {
        $this->authors = $authors;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\TextType::class)
            ->add('text', Type\TextareaType::class)
            ->add('author', Type\ChoiceType::class, ['choices' => array_flip($this->authors->assoc())]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}