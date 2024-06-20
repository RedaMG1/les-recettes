<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610150330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quantity (id INT AUTO_INCREMENT NOT NULL, recette_id INT DEFAULT NULL, ingredients_id INT DEFAULT NULL, qte INT NOT NULL, INDEX IDX_9FF3163689312FE9 (recette_id), INDEX IDX_9FF316363EC4DCE (ingredients_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quantity ADD CONSTRAINT FK_9FF3163689312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE quantity ADD CONSTRAINT FK_9FF316363EC4DCE FOREIGN KEY (ingredients_id) REFERENCES ingredients (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantity DROP FOREIGN KEY FK_9FF3163689312FE9');
        $this->addSql('ALTER TABLE quantity DROP FOREIGN KEY FK_9FF316363EC4DCE');
        $this->addSql('DROP TABLE quantity');
    }
}
