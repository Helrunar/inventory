<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308134934 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD6345CBD743C');
        $this->addSql('DROP INDEX IDX_497DD6345CBD743C ON categorie');
        $this->addSql('ALTER TABLE categorie CHANGE categorie_parente_id parent_category_id INT DEFAULT NULL, CHANGE libelle category VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634796A8F92 FOREIGN KEY (parent_category_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_497DD634796A8F92 ON categorie (parent_category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634796A8F92');
        $this->addSql('DROP INDEX IDX_497DD634796A8F92 ON categorie');
        $this->addSql('ALTER TABLE categorie CHANGE parent_category_id categorie_parente_id INT DEFAULT NULL, CHANGE category libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD6345CBD743C FOREIGN KEY (categorie_parente_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_497DD6345CBD743C ON categorie (categorie_parente_id)');
    }
}
