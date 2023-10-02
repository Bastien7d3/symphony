<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191021084714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE message ADD emetteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE message DROP emetteur');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F79E92E8C FOREIGN KEY (emetteur_id) REFERENCES device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B6BD307F79E92E8C ON message (emetteur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F79E92E8C');
        $this->addSql('DROP INDEX IDX_B6BD307F79E92E8C');
        $this->addSql('ALTER TABLE message ADD emetteur VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE message DROP emetteur_id');
    }
}
