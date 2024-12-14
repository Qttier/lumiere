<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241213234511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_type (id SERIAL NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE record (id SERIAL NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, rate INT DEFAULT NULL, remark TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9B349F91C54C8C93 ON record (type_id)');
        $this->addSql('ALTER TABLE record ADD CONSTRAINT FK_9B349F91C54C8C93 FOREIGN KEY (type_id) REFERENCES media_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE record DROP CONSTRAINT FK_9B349F91C54C8C93');
        $this->addSql('DROP TABLE media_type');
        $this->addSql('DROP TABLE record');
    }
}
