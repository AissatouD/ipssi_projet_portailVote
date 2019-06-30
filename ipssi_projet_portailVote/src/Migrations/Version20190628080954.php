<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190628080954 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meeting CHANGE note_m note_m DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE vote CHANGE id_user_vote id_user_vote INT DEFAULT NULL, CHANGE id_meeting_vote id_meeting_vote INT DEFAULT NULL, CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_meeting id_meeting INT DEFAULT NULL, CHANGE note note INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meeting CHANGE note_m note_m DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
        $this->addSql('ALTER TABLE vote CHANGE id_meeting_vote id_meeting_vote INT DEFAULT NULL, CHANGE id_user_vote id_user_vote INT DEFAULT NULL, CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_meeting id_meeting INT DEFAULT NULL, CHANGE note note INT DEFAULT NULL');
    }
}
