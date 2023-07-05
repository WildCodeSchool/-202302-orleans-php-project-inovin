<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704131455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_wine (user_id INT NOT NULL, wine_id INT NOT NULL, INDEX IDX_2C8D28A1A76ED395 (user_id), INDEX IDX_2C8D28A128A2BD76 (wine_id), PRIMARY KEY(user_id, wine_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_wine ADD CONSTRAINT FK_2C8D28A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_wine ADD CONSTRAINT FK_2C8D28A128A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_wine DROP FOREIGN KEY FK_2C8D28A1A76ED395');
        $this->addSql('ALTER TABLE user_wine DROP FOREIGN KEY FK_2C8D28A128A2BD76');
        $this->addSql('DROP TABLE user_wine');
    }
}
