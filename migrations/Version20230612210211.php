<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230612210211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grape_variety ADD color_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE grape_variety ADD CONSTRAINT FK_ECDE22677ADA1FB5 FOREIGN KEY (color_id) REFERENCES grape_color (id)');
        $this->addSql('CREATE INDEX IDX_ECDE22677ADA1FB5 ON grape_variety (color_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grape_variety DROP FOREIGN KEY FK_ECDE22677ADA1FB5');
        $this->addSql('DROP INDEX IDX_ECDE22677ADA1FB5 ON grape_variety');
        $this->addSql('ALTER TABLE grape_variety DROP color_id');
    }
}
