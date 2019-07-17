<?php

declare(strict_types=1);

namespace App\Model\Article\UseCase\Edit;

use App\Model\Article\Entity\Article\Article;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $text;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromArticle(Article $article): self
    {
        $command = new self($article->getId()->getValue());
        $command->name = $article->getName();
        $command->text = $article->getText();
        return $command;
    }
}