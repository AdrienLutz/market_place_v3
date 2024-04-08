<?php

declare(strict_types=1);

namespace migrations_copy;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240408084116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE distributeurs (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, reference_fk_id INT NOT NULL, categorie_fk_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_BE2DDF8C73D679C0 (reference_fk_id), INDEX IDX_BE2DDF8C500FF400 (categorie_fk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits_distributeurs (produits_id INT NOT NULL, distributeurs_id INT NOT NULL, INDEX IDX_3F2086E8CD11A2CF (produits_id), INDEX IDX_3F2086E89CE97DF1 (distributeurs_id), PRIMARY KEY(produits_id, distributeurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `references` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C73D679C0 FOREIGN KEY (reference_fk_id) REFERENCES `references` (id)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C500FF400 FOREIGN KEY (categorie_fk_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE produits_distributeurs ADD CONSTRAINT FK_3F2086E8CD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produits_distributeurs ADD CONSTRAINT FK_3F2086E89CE97DF1 FOREIGN KEY (distributeurs_id) REFERENCES distributeurs (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C73D679C0');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C500FF400');
        $this->addSql('ALTER TABLE produits_distributeurs DROP FOREIGN KEY FK_3F2086E8CD11A2CF');
        $this->addSql('ALTER TABLE produits_distributeurs DROP FOREIGN KEY FK_3F2086E89CE97DF1');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE distributeurs');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE produits_distributeurs');
        $this->addSql('DROP TABLE `references`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
