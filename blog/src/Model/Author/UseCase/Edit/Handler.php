<?php

declare(strict_types=1);

namespace App\Model\Author\UseCase\Edit;

use App\Model\Author\Entity\Author\AuthorRepository;
use App\Model\Author\Entity\Author\Id;
use App\Model\Author\Entity\Author\Name;
use App\Model\Flusher;

class Handler
{
    private $authors;
    private $flusher;

    public function __construct(AuthorRepository $authors, Flusher $flusher)
    {
        $this->authors = $authors;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $author = $this->authors->get(new Id($command->id));

        $author->edit(
            new Name(
                $command->firstName,
                $command->lastName
            )
        );

        $this->flusher->flush();
    }
}