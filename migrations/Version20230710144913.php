<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710144913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_preference ADD wine_taste_id INT DEFAULT NULL, DROP wine_type');
        $this->addSql('ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BFF4486C22 FOREIGN KEY (wine_taste_id) REFERENCES wine_taste (id)');
        $this->addSql('CREATE INDEX IDX_FA0E76BFF4486C22 ON user_preference (wine_taste_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_preference DROP FOREIGN KEY FK_FA0E76BFF4486C22');
        $this->addSql('DROP INDEX IDX_FA0E76BFF4486C22 ON user_preference');
        $this->addSql('ALTER TABLE user_preference ADD wine_type VARCHAR(255) DEFAULT NULL, DROP wine_taste_id');
    }
}
