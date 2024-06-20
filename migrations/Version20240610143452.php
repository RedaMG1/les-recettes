<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610143452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantite DROP FOREIGN KEY FK_8BF24A7989312FE9');
        $this->addSql('DROP INDEX UNIQ_8BF24A7989312FE9 ON quantite');
        $this->addSql('ALTER TABLE quantite CHANGE recette_id ingredients_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quantite ADD CONSTRAINT FK_8BF24A793EC4DCE FOREIGN KEY (ingredients_id) REFERENCES ingredients (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8BF24A793EC4DCE ON quantite (ingredients_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantite DROP FOREIGN KEY FK_8BF24A793EC4DCE');
        $this->addSql('DROP INDEX UNIQ_8BF24A793EC4DCE ON quantite');
        $this->addSql('ALTER TABLE quantite CHANGE ingredients_id recette_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quantite ADD CONSTRAINT FK_8BF24A7989312FE9 FOREIGN KEY (recette_id) REFERENCES ingredients (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8BF24A7989312FE9 ON quantite (recette_id)');
    }
}
