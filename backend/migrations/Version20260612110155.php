<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260612110155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise ADD spread_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51C29AF074E FOREIGN KEY (spread_id) REFERENCES spread (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AEDAD51C29AF074E ON exercise (spread_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise DROP CONSTRAINT FK_AEDAD51C29AF074E');
        $this->addSql('DROP INDEX UNIQ_AEDAD51C29AF074E');
        $this->addSql('ALTER TABLE exercise DROP spread_id');
    }
}
