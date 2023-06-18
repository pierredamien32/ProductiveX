<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618051316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA881ECFA7');
        $this->addSql('DROP INDEX IDX_BF5476CA881ECFA7 ON notification');
        $this->addSql('ALTER TABLE notification CHANGE status_id_id status_id INT NOT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA6BF700BD ON notification (status_id)');
        $this->addSql('ALTER TABLE objectif DROP FOREIGN KEY FK_E2F86851881ECFA7');
        $this->addSql('DROP INDEX IDX_E2F86851881ECFA7 ON objectif');
        $this->addSql('ALTER TABLE objectif CHANGE status_id_id status_id INT NOT NULL');
        $this->addSql('ALTER TABLE objectif ADD CONSTRAINT FK_E2F868516BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_E2F868516BF700BD ON objectif (status_id)');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9881ECFA7');
        $this->addSql('DROP INDEX IDX_50159CA9881ECFA7 ON projet');
        $this->addSql('ALTER TABLE projet CHANGE status_id_id status_id INT NOT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA96BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_50159CA96BF700BD ON projet (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA6BF700BD');
        $this->addSql('DROP INDEX IDX_BF5476CA6BF700BD ON notification');
        $this->addSql('ALTER TABLE notification CHANGE status_id status_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA881ECFA7 ON notification (status_id_id)');
        $this->addSql('ALTER TABLE objectif DROP FOREIGN KEY FK_E2F868516BF700BD');
        $this->addSql('DROP INDEX IDX_E2F868516BF700BD ON objectif');
        $this->addSql('ALTER TABLE objectif CHANGE status_id status_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE objectif ADD CONSTRAINT FK_E2F86851881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_E2F86851881ECFA7 ON objectif (status_id_id)');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA96BF700BD');
        $this->addSql('DROP INDEX IDX_50159CA96BF700BD ON projet');
        $this->addSql('ALTER TABLE projet CHANGE status_id status_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_50159CA9881ECFA7 ON projet (status_id_id)');
    }
}
