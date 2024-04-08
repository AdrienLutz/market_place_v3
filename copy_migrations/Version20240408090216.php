<?php

declare(strict_types=1);

namespace migrations_copy;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240408090216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits ADD user_fk_id INT NOT NULL');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C47B5E288 FOREIGN KEY (user_fk_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BE2DDF8C47B5E288 ON produits (user_fk_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C47B5E288');
        $this->addSql('DROP INDEX IDX_BE2DDF8C47B5E288 ON produits');
        $this->addSql('ALTER TABLE produits DROP user_fk_id');
    }
}
