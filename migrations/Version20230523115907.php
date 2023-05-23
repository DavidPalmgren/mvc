<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523115907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__library AS SELECT id, titel, isbn, författare, bild, beskrivning FROM library');
        $this->addSql('DROP TABLE library');
        $this->addSql('CREATE TABLE library (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titel VARCHAR(255) NOT NULL, isbn INTEGER NOT NULL, författare VARCHAR(255) NOT NULL, bild VARCHAR(255) NOT NULL, beskrivning VARCHAR(500) DEFAULT NULL)');
        $this->addSql('INSERT INTO library (id, titel, isbn, författare, bild, beskrivning) SELECT id, titel, isbn, författare, bild, beskrivning FROM __temp__library');
        $this->addSql('DROP TABLE __temp__library');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__library AS SELECT id, titel, isbn, författare, bild, beskrivning FROM library');
        $this->addSql('DROP TABLE library');
        $this->addSql('CREATE TABLE library (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titel VARCHAR(255) NOT NULL, isbn INTEGER NOT NULL, författare VARCHAR(255) NOT NULL, bild VARCHAR(255) NOT NULL, beskrivning VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO library (id, titel, isbn, författare, bild, beskrivning) SELECT id, titel, isbn, författare, bild, beskrivning FROM __temp__library');
        $this->addSql('DROP TABLE __temp__library');
    }
}
