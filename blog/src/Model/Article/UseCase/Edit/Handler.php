<?php

declare(strict_types=1);

namespace App\Model\Article\UseCase\Edit;

use App\Model\Article\Entity\Article\ArticleRepository;
use App\Model\Article\Entity\Article\Id;
use App\Model\Flusher;

class Handler
{
    private $articles;
    private $flusher;

    public function __construct(ArticleRepository $articles, Flusher $flusher)
    {
        $this->articles = $articles;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $article = $this->articles->get(new Id($command->id));

        $article->edit(
            $command->name,
            $command->text
        );

        $this->flusher->flush();
    }
}