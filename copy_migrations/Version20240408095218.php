<?php

declare(strict_types=1);

namespace migrations_copy;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240408095218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C500FF400');
        $this->addSql('ALTER TABLE produits CHANGE categorie_fk_id categorie_fk_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C500FF400 FOREIGN KEY (categorie_fk_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C500FF400');
        $this->addSql('ALTER TABLE produits CHANGE categorie_fk_id categorie_fk_id INT NOT NULL');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C500FF400 FOREIGN KEY (categorie_fk_id) REFERENCES produits (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
