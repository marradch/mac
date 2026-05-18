<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260501112633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deck ADD show BOOLEAN DEFAULT false NOT NULL');
        $this->addSql('ALTER TABLE deck ALTER order_in_list SET DEFAULT 1');
        $this->addSql('ALTER TABLE deck ALTER order_in_list SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deck DROP show');
        $this->addSql('ALTER TABLE deck ALTER order_in_list DROP DEFAULT');
        $this->addSql('ALTER TABLE deck ALTER order_in_list DROP NOT NULL');
    }
}
