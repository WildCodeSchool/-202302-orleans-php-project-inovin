<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613150910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wine (id INT AUTO_INCREMENT NOT NULL, grape_variety_id INT NOT NULL, name VARCHAR(255) NOT NULL, year INT NOT NULL, volume  DOUBLE PRECISION NOT NULL, alcohol_percent NUMERIC(3, 1) NOT NULL, price NUMERIC(8, 2) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_560C646882CC410A (grape_variety_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C646882CC410A FOREIGN KEY (grape_variety_id) REFERENCES grape_variety (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C646882CC410A');
        $this->addSql('DROP TABLE wine');
    }
}
