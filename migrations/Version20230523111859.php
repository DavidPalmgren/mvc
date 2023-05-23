<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523111859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE library ADD COLUMN beskrivning VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__library AS SELECT id, titel, isbn, författare, bild FROM library');
        $this->addSql('DROP TABLE library');
        $this->addSql('CREATE TABLE library (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titel VARCHAR(255) NOT NULL, isbn INTEGER NOT NULL, författare VARCHAR(255) NOT NULL, bild VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO library (id, titel, isbn, författare, bild) SELECT id, titel, isbn, författare, bild FROM __temp__library');
        $this->addSql('DROP TABLE __temp__library');
    }
}
