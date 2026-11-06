<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261106163444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise ALTER difficulty TYPE VARCHAR(20)');
        $this->addSql('ALTER TABLE exercise ALTER difficulty SET DEFAULT \'easy\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise ALTER difficulty TYPE INT');
        $this->addSql('ALTER TABLE exercise ALTER difficulty SET DEFAULT 1');
    }
}
