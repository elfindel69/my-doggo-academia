<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029074329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE chien_photo');
        $this->addSql('ALTER TABLE photo ADD chien_id INT NOT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418BFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id)');
        $this->addSql('CREATE INDEX IDX_14B78418BFCF400E ON photo (chien_id)');
        $this->addSql('ALTER TABLE utilisateur ADD nom VARCHAR(255) DEFAULT NULL, CHANGE ville_id ville_id INT DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL, CHANGE telephone telephone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chien_photo (chien_id INT NOT NULL, photo_id INT NOT NULL, INDEX IDX_FC8E62EEBFCF400E (chien_id), INDEX IDX_FC8E62EE7E9E4C8C (photo_id), PRIMARY KEY(chien_id, photo_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE chien_photo ADD CONSTRAINT FK_FC8E62EE7E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chien_photo ADD CONSTRAINT FK_FC8E62EEBFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418BFCF400E');
        $this->addSql('DROP INDEX IDX_14B78418BFCF400E ON photo');
        $this->addSql('ALTER TABLE photo DROP chien_id');
        $this->addSql('ALTER TABLE utilisateur DROP nom, CHANGE ville_id ville_id INT NOT NULL, CHANGE adresse adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
