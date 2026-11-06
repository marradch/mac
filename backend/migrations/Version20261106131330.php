<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261106131330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise ADD show_on_homepage BOOLEAN DEFAULT false NOT NULL');
        $this->addSql('ALTER TABLE exercise ADD min_execution_min INT DEFAULT 5 NOT NULL');
        $this->addSql('ALTER TABLE exercise ADD max_execution_min INT DEFAULT 30 NOT NULL');
        $this->addSql('ALTER TABLE exercise ADD difficulty INT DEFAULT 1 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise DROP show_on_homepage');
        $this->addSql('ALTER TABLE exercise DROP min_execution_min');
        $this->addSql('ALTER TABLE exercise DROP max_execution_min');
        $this->addSql('ALTER TABLE exercise DROP difficulty');
    }
}
