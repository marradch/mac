<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261104141623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE topic ADD show BOOLEAN DEFAULT true NOT NULL');
        $this->addSql('ALTER INDEX idx_12d9a42e2c40c3e RENAME TO IDX_40C6C4481F55203D');
        $this->addSql('ALTER INDEX idx_e925cc4a8ef8271a RENAME TO IDX_66F8148CC5596CC7');
        $this->addSql('ALTER INDEX idx_1a455f4e2c40c3e RENAME TO IDX_6F17DF171F55203D');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE topic DROP show');
        $this->addSql('ALTER INDEX idx_40c6c4481f55203d RENAME TO idx_12d9a42e2c40c3e');
        $this->addSql('ALTER INDEX idx_66f8148cc5596cc7 RENAME TO idx_e925cc4a8ef8271a');
        $this->addSql('ALTER INDEX idx_6f17df171f55203d RENAME TO idx_1a455f4e2c40c3e');
    }
}
