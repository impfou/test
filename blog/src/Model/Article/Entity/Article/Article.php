<?php

declare(strict_types=1);

namespace App\Model\Article\Entity\Article;

use App\Model\Author\Entity\Author\Author;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="article_articles")
 */
class Article
{
    /**
     * @var Id
     * @ORM\Column(type="article_article_id")
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
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
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

    public function __construct(Id $id, \DateTimeImmutable $date, Author $author, string $name, string $text)
    {
        $this->id = $id;
        $this->date = $date;
        $this->author = $author;
        $this->name = $name;
        $this->text = $text;
    }

    public function edit(Author $author, string $name, string $text): void
    {
        $this->author = $author;
        $this->name = $name;
        $this->text = $text;
        $this->updateDate = new \DateTimeImmutable();
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

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}