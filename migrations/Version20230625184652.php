<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230625184652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tache_status (id INT AUTO_INCREMENT NOT NULL, tache_id INT NOT NULL, status_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_97FC5AEDD2235D39 (tache_id), INDEX IDX_97FC5AED6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tache_status ADD CONSTRAINT FK_97FC5AEDD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id)');
        $this->addSql('ALTER TABLE tache_status ADD CONSTRAINT FK_97FC5AED6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache_status DROP FOREIGN KEY FK_97FC5AEDD2235D39');
        $this->addSql('ALTER TABLE tache_status DROP FOREIGN KEY FK_97FC5AED6BF700BD');
        $this->addSql('DROP TABLE tache_status');
    }
}
