<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190717194351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE article_articles (id UUID NOT NULL, author_id UUID NOT NULL, name VARCHAR(255) NOT NULL, text TEXT NOT NULL, slug VARCHAR(128) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EA35C503989D9B62 ON article_articles (slug)');
        $this->addSql('CREATE INDEX IDX_EA35C503F675F31B ON article_articles (author_id)');
        $this->addSql('COMMENT ON COLUMN article_articles.id IS \'(DC2Type:article_article_id)\'');
        $this->addSql('COMMENT ON COLUMN article_articles.author_id IS \'(DC2Type:author_author_id)\'');
        $this->addSql('COMMENT ON COLUMN article_articles.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN article_articles.update_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE article_articles ADD CONSTRAINT FK_EA35C503F675F31B FOREIGN KEY (author_id) REFERENCES author_authors (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE article_articles');
    }
}
