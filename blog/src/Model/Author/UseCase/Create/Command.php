<?php

declare(strict_types=1);

namespace App\Model\Author\UseCase\Create;

use App\Model\Author\Entity\Author\Id;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
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

    public function __construct(Id $id)
    {
        $this->id = $id;
    }
}