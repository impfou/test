<?php

namespace App\DataFixtures\Author;

use App\Model\Author\Entity\Author\Author;
use App\Model\Author\Entity\Author\Id;
use App\Model\Author\Entity\Author\Name;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AuthorFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $author = $this->createAuthor(
            new Name('Elon', 'Musk')
        );
        $manager->persist($author);

        $manager->flush();
    }

    private function createAuthor(Name $name): Author
    {
        return new Author(
            new Id(Id::next()),
            new \DateTimeImmutable(),
            $name
        );
    }
}