<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240615154918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recette_tags (recette_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_22BC7E7D89312FE9 (recette_id), INDEX IDX_22BC7E7D8D7B4FB4 (tags_id), PRIMARY KEY(recette_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recette_tags ADD CONSTRAINT FK_22BC7E7D89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_tags ADD CONSTRAINT FK_22BC7E7D8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quantite DROP FOREIGN KEY FK_8BF24A793EC4DCE');
        $this->addSql('ALTER TABLE quantite DROP FOREIGN KEY FK_8BF24A7989312FE9');
        $this->addSql('DROP TABLE quantite');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quantite (id INT AUTO_INCREMENT NOT NULL, ingredients_id INT DEFAULT NULL, recette_id INT DEFAULT NULL, qte INT NOT NULL, UNIQUE INDEX UNIQ_8BF24A793EC4DCE (ingredients_id), UNIQUE INDEX UNIQ_8BF24A7989312FE9 (recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quantite ADD CONSTRAINT FK_8BF24A793EC4DCE FOREIGN KEY (ingredients_id) REFERENCES ingredients (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE quantite ADD CONSTRAINT FK_8BF24A7989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE recette_tags DROP FOREIGN KEY FK_22BC7E7D89312FE9');
        $this->addSql('ALTER TABLE recette_tags DROP FOREIGN KEY FK_22BC7E7D8D7B4FB4');
        $this->addSql('DROP TABLE recette_tags');
    }
}
