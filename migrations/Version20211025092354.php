<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025092354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adoptant (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, annonceur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_creation DATETIME NOT NULL, date_ma_j DATETIME NOT NULL, a_pourvoir TINYINT(1) DEFAULT NULL, INDEX IDX_F65593E5C8764012 (annonceur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonceur (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chien (id INT AUTO_INCREMENT NOT NULL, annonce_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, age INT NOT NULL, taille DOUBLE PRECISION NOT NULL, poids DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, lof TINYINT(1) NOT NULL, sociable TINYINT(1) DEFAULT NULL, antecedents LONGTEXT NOT NULL, adopte TINYINT(1) DEFAULT NULL, INDEX IDX_13A4067E8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chien_race (chien_id INT NOT NULL, race_id INT NOT NULL, INDEX IDX_5B5D7EE8BFCF400E (chien_id), INDEX IDX_5B5D7EE86E59D40D (race_id), PRIMARY KEY(chien_id, race_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chien_photo (chien_id INT NOT NULL, photo_id INT NOT NULL, INDEX IDX_FC8E62EEBFCF400E (chien_id), INDEX IDX_FC8E62EE7E9E4C8C (photo_id), PRIMARY KEY(chien_id, photo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_adoption (id INT AUTO_INCREMENT NOT NULL, annonceur_id INT NOT NULL, adoptant_id INT NOT NULL, annonce_id INT NOT NULL, acceptee TINYINT(1) DEFAULT NULL, INDEX IDX_AB87FF6BC8764012 (annonceur_id), INDEX IDX_AB87FF6B8D8B49F9 (adoptant_id), INDEX IDX_AB87FF6B8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_adoption_chien (demande_adoption_id INT NOT NULL, chien_id INT NOT NULL, INDEX IDX_9468EEF4C23B0AAB (demande_adoption_id), INDEX IDX_9468EEF4BFCF400E (chien_id), PRIMARY KEY(demande_adoption_id, chien_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_C1765B6398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, expediteur_id INT NOT NULL, destinataire_id INT NOT NULL, contenu LONGTEXT NOT NULL, date_envoi DATETIME NOT NULL, est_lu TINYINT(1) DEFAULT NULL, INDEX IDX_B6BD307F10335F61 (expediteur_id), INDEX IDX_B6BD307FA4F84F6E (destinataire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, ville_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), INDEX IDX_1D1C63B3A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, departement_id INT NOT NULL, nom VARCHAR(255) NOT NULL, code_postal VARCHAR(10) NOT NULL, INDEX IDX_43C3D9C3CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adoptant ADD CONSTRAINT FK_7B42F2ABF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5C8764012 FOREIGN KEY (annonceur_id) REFERENCES annonceur (id)');
        $this->addSql('ALTER TABLE annonceur ADD CONSTRAINT FK_E795BC5EBF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chien ADD CONSTRAINT FK_13A4067E8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE chien_race ADD CONSTRAINT FK_5B5D7EE8BFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chien_race ADD CONSTRAINT FK_5B5D7EE86E59D40D FOREIGN KEY (race_id) REFERENCES race (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chien_photo ADD CONSTRAINT FK_FC8E62EEBFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chien_photo ADD CONSTRAINT FK_FC8E62EE7E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande_adoption ADD CONSTRAINT FK_AB87FF6BC8764012 FOREIGN KEY (annonceur_id) REFERENCES annonceur (id)');
        $this->addSql('ALTER TABLE demande_adoption ADD CONSTRAINT FK_AB87FF6B8D8B49F9 FOREIGN KEY (adoptant_id) REFERENCES adoptant (id)');
        $this->addSql('ALTER TABLE demande_adoption ADD CONSTRAINT FK_AB87FF6B8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE demande_adoption_chien ADD CONSTRAINT FK_9468EEF4C23B0AAB FOREIGN KEY (demande_adoption_id) REFERENCES demande_adoption (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande_adoption_chien ADD CONSTRAINT FK_9468EEF4BFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F10335F61 FOREIGN KEY (expediteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA4F84F6E FOREIGN KEY (destinataire_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_adoption DROP FOREIGN KEY FK_AB87FF6B8D8B49F9');
        $this->addSql('ALTER TABLE chien DROP FOREIGN KEY FK_13A4067E8805AB2F');
        $this->addSql('ALTER TABLE demande_adoption DROP FOREIGN KEY FK_AB87FF6B8805AB2F');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5C8764012');
        $this->addSql('ALTER TABLE demande_adoption DROP FOREIGN KEY FK_AB87FF6BC8764012');
        $this->addSql('ALTER TABLE chien_race DROP FOREIGN KEY FK_5B5D7EE8BFCF400E');
        $this->addSql('ALTER TABLE chien_photo DROP FOREIGN KEY FK_FC8E62EEBFCF400E');
        $this->addSql('ALTER TABLE demande_adoption_chien DROP FOREIGN KEY FK_9468EEF4BFCF400E');
        $this->addSql('ALTER TABLE demande_adoption_chien DROP FOREIGN KEY FK_9468EEF4C23B0AAB');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3CCF9E01E');
        $this->addSql('ALTER TABLE chien_photo DROP FOREIGN KEY FK_FC8E62EE7E9E4C8C');
        $this->addSql('ALTER TABLE chien_race DROP FOREIGN KEY FK_5B5D7EE86E59D40D');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6398260155');
        $this->addSql('ALTER TABLE adoptant DROP FOREIGN KEY FK_7B42F2ABF396750');
        $this->addSql('ALTER TABLE annonceur DROP FOREIGN KEY FK_E795BC5EBF396750');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F10335F61');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA4F84F6E');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3A73F0036');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE adoptant');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE annonceur');
        $this->addSql('DROP TABLE chien');
        $this->addSql('DROP TABLE chien_race');
        $this->addSql('DROP TABLE chien_photo');
        $this->addSql('DROP TABLE demande_adoption');
        $this->addSql('DROP TABLE demande_adoption_chien');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE ville');
    }
}
