<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230717094536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wine ADD wine_region_id INT DEFAULT NULL, ADD wine_taste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C64681AFFDA6 FOREIGN KEY (wine_region_id) REFERENCES wine_region (id)');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C6468F4486C22 FOREIGN KEY (wine_taste_id) REFERENCES wine_taste (id)');
        $this->addSql('CREATE INDEX IDX_560C64681AFFDA6 ON wine (wine_region_id)');
        $this->addSql('CREATE INDEX IDX_560C6468F4486C22 ON wine (wine_taste_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C64681AFFDA6');
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C6468F4486C22');
        $this->addSql('DROP INDEX IDX_560C64681AFFDA6 ON wine');
        $this->addSql('DROP INDEX IDX_560C6468F4486C22 ON wine');
        $this->addSql('ALTER TABLE wine DROP wine_region_id, DROP wine_taste_id');
    }
}
