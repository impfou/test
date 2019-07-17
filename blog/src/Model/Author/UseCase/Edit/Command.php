<?php

declare(strict_types=1);

namespace App\Model\Author\UseCase\Edit;

use App\Model\Author\Entity\Author\Author;
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
    public $firstName;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $lastName;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromAuthor(Author $author): self
    {
        $command = new self($author->getId()->getValue());
        $command->firstName = $author->getName()->getFirst();
        $command->lastName = $author->getName()->getLast();
        return $command;
    }
}