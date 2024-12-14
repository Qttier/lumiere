<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241213234534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO media_type (type) VALUES ('music')");
        $this->addSql("INSERT INTO media_type (type) VALUES ('movie')");
        $this->addSql("INSERT INTO media_type (type) VALUES ('game')");
        $this->addSql("INSERT INTO media_type (type) VALUES ('book')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
