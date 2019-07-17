<?php

namespace App\DataFixtures\Article;

use App\Model\Article\Entity\Article\Article;
use App\Model\Article\Entity\Article\Id;
use App\Model\Author\Entity\Author\Id as AuthorId;
use App\Model\Author\Entity\Author\Author;
use App\Model\Author\Entity\Author\Name;
use App\ReadModel\Author\AuthorFetcher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixture extends Fixture
{
    private $authors;

    public function __construct(AuthorFetcher $authors)
    {
        $this->authors = $authors;
    }

    public function load(ObjectManager $manager)
    {
        $author = $this->createAuthor(
            new Name('Bill', 'Gates')
        );

        $firstArticle = $this->createFirstArticle($author);
        $secondArticle = $this->createSecondArticle($author);

        $manager->persist($author);
        $manager->persist($firstArticle);
        $manager->persist($secondArticle);

        $manager->flush();
    }

    private function createAuthor(Name $name): Author
    {
        return new Author(
            new AuthorId(Id::next()),
            new \DateTimeImmutable(),
            $name
        );
    }

    private function createFirstArticle(Author $author): Article
    {
        return new Article(
            Id::next(),
            new \DateTimeImmutable(),
            $author,
            'This obscure organization will feed our future',
            '<p>It’s a question asked every day in homes around the world. No other organization has done as much to ensure families—especially the poorest—have an answer to that question as CGIAR, the world’s largest global agricultural research organization.</p><p>More than 50 years ago, CGIAR’s research into high-yielding, disease-resistant rice and wheat launched the Green Revolution, saving more than a billion people from starvation. In the years since then, their work on everything from livestock and potatoes to rice and maize has helped reduce poverty, increase food security, and improve nutrition.</p><p>Never heard of CGIAR? You’re not alone. It’s an organization that defies easy brand recognition. For starters, its name is often mistaken for “cigar,” suggesting a link to the tobacco industry. And it doesn’t help that CGIAR is not a single organization, but a network of 15 independent research centers, most referred to by their own confusing acronyms. The list includes CIFOR, ICARDA, CIAT, ICRISAT, IFPRI, IITA, ILRI, CIMMYT, CIP, IRRI, IWMI, and ICRAF, leaving the uninitiated feeling as if they’ve fallen into a bowl of alphabet soup.</p>'
        );
    }

    private function createSecondArticle(Author $author): Article
    {
        return new Article(
            Id::next(),
            new \DateTimeImmutable(),
            $author,
            'Here’s one great way to use your tech skills',
            '<p>These days I spend a lot of my time thinking about how technology can help the poorest people in the world improve their lives. It’s been a big focus for me since before Melinda and I launched our foundation. But looking back, I think I could have started down this path even sooner than I did.</p><p>People with a STEM background have a lot to offer the world of global health and development. That’s one of the reasons why I write about innovation so often here on TGN: I want to encourage software developers, inventors, and scientists to consider how they can use their skills to fight inequity. It’s deeply rewarding. You get the chance to learn from super-capable people—health care workers, farmers, political leaders—and work with them on tools that will empower them.</p><p>Last year I heard a talk from a young technologist who came to this realization sooner than I did. His name is William Wu, and he gave a fascinating demonstration at our foundation’s annual Goalkeepers meeting in New York City.</p>'
        );
    }
}