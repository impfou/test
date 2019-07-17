<?php

declare(strict_types=1);

namespace App\Model\Author\Entity\Author;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class AuthorRepository
{
    /**
     * @var EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Author::class);
        $this->em = $em;
    }

    public function get(Id $id): Author
    {
        /** @var Author $author */
        if (!$author = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Author is not found.');
        }
        return $author;
    }

    public function add(Author $author): void
    {
        $this->em->persist($author);
    }
}