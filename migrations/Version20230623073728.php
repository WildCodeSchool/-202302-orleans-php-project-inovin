<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230623073728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tasting_sheet ADD wine_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tasting_sheet ADD CONSTRAINT FK_99DA4A2728A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id)');
        $this->addSql('CREATE INDEX IDX_99DA4A2728A2BD76 ON tasting_sheet (wine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tasting_sheet DROP FOREIGN KEY FK_99DA4A2728A2BD76');
        $this->addSql('DROP INDEX IDX_99DA4A2728A2BD76 ON tasting_sheet');
        $this->addSql('ALTER TABLE tasting_sheet DROP wine_id');
    }
}
