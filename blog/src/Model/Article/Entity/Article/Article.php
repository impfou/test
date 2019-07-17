<?php

declare(strict_types=1);

namespace App\Model\Article\Entity\Article;

use App\Model\Author\Entity\Author\Author;

/**
 * @ORM\Entity
 * @ORM\Table(name="article_articles")
 */
class Article
{
    /**
     * @var Id
     * @ORM\Column(type="author_article_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $slug;

    /**
     * @var Author
     * @ORM\ManyToOne(targetEntity="App\Model\Author\Entity\Author\Author", inversedBy="changes")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $author;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", nullable=true, name="update_date")
     */
    private $updateDate;

    public function __construct(Id $id, \DateTimeImmutable $date, string $name, string $text)
    {
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}