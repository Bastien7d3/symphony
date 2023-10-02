<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191017143344 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE device_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE device (id INT NOT NULL, name VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE message (id INT NOT NULL, texte VARCHAR(200) NOT NULL, image BYTEA DEFAULT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_fin TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE message_device (message_id INT NOT NULL, device_id INT NOT NULL, PRIMARY KEY(message_id, device_id))');
        $this->addSql('CREATE INDEX IDX_3E082B81537A1329 ON message_device (message_id)');
        $this->addSql('CREATE INDEX IDX_3E082B8194A4C7D4 ON message_device (device_id)');
        $this->addSql('ALTER TABLE message_device ADD CONSTRAINT FK_3E082B81537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message_device ADD CONSTRAINT FK_3E082B8194A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE message_device DROP CONSTRAINT FK_3E082B8194A4C7D4');
        $this->addSql('ALTER TABLE message_device DROP CONSTRAINT FK_3E082B81537A1329');
        $this->addSql('DROP SEQUENCE device_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE message_id_seq CASCADE');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_device');
    }
}
