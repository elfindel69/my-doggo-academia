<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025095006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD demande_adoption_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FC23B0AAB FOREIGN KEY (demande_adoption_id) REFERENCES demande_adoption (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FC23B0AAB ON message (demande_adoption_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FC23B0AAB');
        $this->addSql('DROP INDEX IDX_B6BD307FC23B0AAB ON message');
        $this->addSql('ALTER TABLE message DROP demande_adoption_id');
    }
}
