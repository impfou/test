<?php

declare(strict_types=1);

namespace App\Model\Article\UseCase\Create;

use App\Model\Article\Entity\Article\Id;
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
    public $name;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $text;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $author;

    public function __construct(Id $id)
    {
        $this->id = $id;
    }
}