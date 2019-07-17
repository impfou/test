<?php

declare(strict_types=1);

namespace App\Model\Article\UseCase\Create;

use App\Model\Article\Entity\Article\Article;
use App\Model\Article\Entity\Article\ArticleRepository;
use App\Model\Author\Entity\Author\AuthorRepository;
use App\Model\Author\Entity\Author\Id;
use App\Model\Flusher;


class Handler
{
    private $articles;
    private $authors;
    private $flusher;

    public function __construct(ArticleRepository $articles, AuthorRepository $authors, Flusher $flusher)
    {
        $this->articles = $articles;
        $this->authors = $authors;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $author = $this->authors->get(new Id($command->author));

        $article = new Article(
            $command->id,
            new \DateTimeImmutable(),
            $author,
            $command->name,
            $command->text
        );

        $this->articles->add($article);

        $this->flusher->flush();
    }
}
