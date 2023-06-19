<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615081440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE session_wine (session_id INT NOT NULL, wine_id INT NOT NULL, INDEX IDX_907D6442613FECDF (session_id), INDEX IDX_907D644228A2BD76 (wine_id), PRIMARY KEY(session_id, wine_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session_wine ADD CONSTRAINT FK_907D6442613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_wine ADD CONSTRAINT FK_907D644228A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wine RENAME INDEX idx_560c646882cc410a TO IDX_560C6468ED00A18A');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session_wine DROP FOREIGN KEY FK_907D6442613FECDF');
        $this->addSql('ALTER TABLE session_wine DROP FOREIGN KEY FK_907D644228A2BD76');
        $this->addSql('DROP TABLE session_wine');
        $this->addSql('ALTER TABLE wine RENAME INDEX idx_560c6468ed00a18a TO IDX_560C646882CC410A');
    }
}
