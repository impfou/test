<?php

declare(strict_types=1);

namespace App\Model\Article\Entity\Article;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class ArticleRepository
{
    /**
     * @var EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Article::class);
        $this->em = $em;
    }

    public function get(Id $id): Article
    {
        /** @var Article $article */
        if (!$article = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Article is not found.');
        }
        return $article;
    }

    public function add(Article $article): void
    {
        $this->em->persist($article);
    }
}