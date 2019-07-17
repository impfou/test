<?php

declare(strict_types=1);

namespace App\Model\Author\Entity\Author;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="author_authors")
 */
class Author
{
    /**
     * @var Id
     * @ORM\Column(type="author_author_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @var Name
     * @ORM\Embedded(class="Name")
     */
    private $name;

    public function __construct(Id $id, \DateTimeImmutable $date, Name $name)
    {
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
    }

    public function edit(Name $name): void
    {
        $this->name = $name;
    }
    
    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}