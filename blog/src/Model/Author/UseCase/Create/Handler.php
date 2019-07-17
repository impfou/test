<?php

declare(strict_types=1);

namespace App\Model\Author\UseCase\Create;

use App\Model\Author\Entity\Author\Author;
use App\Model\Author\Entity\Author\AuthorRepository;
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
        $member = new Author(
            $command->id,
            new \DateTimeImmutable(),
            new Name(
                $command->firstName,
                $command->lastName
            )
        );

        $this->authors->add($member);

        $this->flusher->flush();
    }
}
