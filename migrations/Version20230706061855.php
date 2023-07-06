<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706061855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favorite_recipe (recipe_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E63DDDCD59D8A214 (recipe_id), INDEX IDX_E63DDDCDA76ED395 (user_id), PRIMARY KEY(recipe_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorite_recipe ADD CONSTRAINT FK_E63DDDCD59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_recipe ADD CONSTRAINT FK_E63DDDCDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite_recipe DROP FOREIGN KEY FK_E63DDDCD59D8A214');
        $this->addSql('ALTER TABLE favorite_recipe DROP FOREIGN KEY FK_E63DDDCDA76ED395');
        $this->addSql('DROP TABLE favorite_recipe');
    }
}
