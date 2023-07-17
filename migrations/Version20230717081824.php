<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230717081824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_preference ADD wine_region_id INT DEFAULT NULL, DROP wine_region');
        $this->addSql('ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BF1AFFDA6 FOREIGN KEY (wine_region_id) REFERENCES wine_region (id)');
        $this->addSql('CREATE INDEX IDX_FA0E76BF1AFFDA6 ON user_preference (wine_region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_preference DROP FOREIGN KEY FK_FA0E76BF1AFFDA6');
        $this->addSql('DROP INDEX IDX_FA0E76BF1AFFDA6 ON user_preference');
        $this->addSql('ALTER TABLE user_preference ADD wine_region VARCHAR(255) DEFAULT NULL, DROP wine_region_id');
    }
}
