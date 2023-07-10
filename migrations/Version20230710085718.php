<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710085718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine_taste (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_preference ADD grape_color_id INT DEFAULT NULL, ADD region_id INT DEFAULT NULL, ADD wine_taste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BF2A0B663A FOREIGN KEY (grape_color_id) REFERENCES grape_color (id)');
        $this->addSql('ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BF98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE user_preference ADD CONSTRAINT FK_FA0E76BFF4486C22 FOREIGN KEY (wine_taste_id) REFERENCES wine_taste (id)');
        $this->addSql('CREATE INDEX IDX_FA0E76BF2A0B663A ON user_preference (grape_color_id)');
        $this->addSql('CREATE INDEX IDX_FA0E76BF98260155 ON user_preference (region_id)');
        $this->addSql('CREATE INDEX IDX_FA0E76BFF4486C22 ON user_preference (wine_taste_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_preference DROP FOREIGN KEY FK_FA0E76BF98260155');
        $this->addSql('ALTER TABLE user_preference DROP FOREIGN KEY FK_FA0E76BFF4486C22');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE wine_taste');
        $this->addSql('ALTER TABLE user_preference DROP FOREIGN KEY FK_FA0E76BF2A0B663A');
        $this->addSql('DROP INDEX IDX_FA0E76BF2A0B663A ON user_preference');
        $this->addSql('DROP INDEX IDX_FA0E76BF98260155 ON user_preference');
        $this->addSql('DROP INDEX IDX_FA0E76BFF4486C22 ON user_preference');
        $this->addSql('ALTER TABLE user_preference DROP grape_color_id, DROP region_id, DROP wine_taste_id');
    }
}
