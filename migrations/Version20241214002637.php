<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241214002637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE record ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE record ADD CONSTRAINT FK_9B349F917E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9B349F917E3C61F9 ON record (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE record DROP CONSTRAINT FK_9B349F917E3C61F9');
        $this->addSql('DROP INDEX IDX_9B349F917E3C61F9');
        $this->addSql('ALTER TABLE record DROP owner_id');
    }
}
