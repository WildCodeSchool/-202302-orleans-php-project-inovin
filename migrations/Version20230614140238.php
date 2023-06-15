<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614140238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wine ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE wine RENAME INDEX idx_560c646882cc410a TO IDX_560C6468ED00A18A');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wine DROP updated_at');
        $this->addSql('ALTER TABLE wine RENAME INDEX idx_560c6468ed00a18a TO IDX_560C646882CC410A');
    }
}
