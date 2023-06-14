<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614091719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD vehicule_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D4A4A3511 ON commande (vehicule_id)');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D4A4A3511');
        $this->addSql('DROP INDEX IDX_292FFF1D4A4A3511 ON vehicule');
        $this->addSql('ALTER TABLE vehicule DROP vehicule_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D4A4A3511');
        $this->addSql('DROP INDEX IDX_6EEAA67D4A4A3511 ON commande');
        $this->addSql('ALTER TABLE commande DROP vehicule_id');
        $this->addSql('ALTER TABLE vehicule ADD vehicule_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_292FFF1D4A4A3511 ON vehicule (vehicule_id)');
    }
}
