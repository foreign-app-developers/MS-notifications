<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301143207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE period_notification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE period_notification (id INT NOT NULL, type VARCHAR(255) CHECK(type IN (\'sms\', \'email\', \'push\', \'tg\')) NOT NULL, content TEXT NOT NULL, title VARCHAR(255) NOT NULL, from_val VARCHAR(255) NOT NULL, to_val VARCHAR(255) NOT NULL, when_send VARCHAR(255) NOT NULL, is_history BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN period_notification.type IS \'(DC2Type:NotificationTypes)\'');
        $this->addSql('CREATE TABLE user_requisite (user_id INT NOT NULL, requisite VARCHAR(255) NOT NULL, type VARCHAR(255) CHECK(type IN (\'sms\', \'email\', \'push\', \'tg\')) NOT NULL, PRIMARY KEY(user_id, requisite))');
        $this->addSql('COMMENT ON COLUMN user_requisite.type IS \'(DC2Type:NotificationTypes)\'');
        $this->addSql('ALTER TABLE notifications ADD is_history BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE notifications ADD is_sent BOOLEAN NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE period_notification_id_seq CASCADE');
        $this->addSql('DROP TABLE period_notification');
        $this->addSql('DROP TABLE user_requisite');
        $this->addSql('ALTER TABLE Notifications DROP is_history');
        $this->addSql('ALTER TABLE Notifications DROP is_sent');
    }
}
