<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240216155518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE Notifications_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE Notifications (id INT NOT NULL, type VARCHAR(255) CHECK(type IN (\'sms\', \'email\', \'push\', \'tg\')) NOT NULL, content TEXT NOT NULL, title VARCHAR(255) NOT NULL, is_readed BOOLEAN NOT NULL, moment TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, from_val VARCHAR(255) NOT NULL, to_val VARCHAR(255) NOT NULL, time_to_send TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN Notifications.type IS \'(DC2Type:NotificationTypes)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE Notifications_id_seq CASCADE');
        $this->addSql('DROP TABLE Notifications');
    }
}
