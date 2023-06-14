<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614201706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, entreprise_id_id INT NOT NULL, formule_id_id INT NOT NULL, debut_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', fin_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_351268BBDAC5BE2B (entreprise_id_id), INDEX IDX_351268BBD9B357CE (formule_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, parent_id INT DEFAULT NULL, tache_id_id INT NOT NULL, contenu VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_67F068BC9D86650F (user_id_id), INDEX IDX_67F068BC727ACA70 (parent_id), INDEX IDX_67F068BCE0894996 (tache_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, entreprise_id_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, poste VARCHAR(255) DEFAULT NULL, debutcontrat_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', fincontrat_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_F804D3B99D86650F (user_id_id), INDEX IDX_F804D3B9DAC5BE2B (entreprise_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, sigle VARCHAR(255) NOT NULL, denomination VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D19FA609D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formule (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, duree VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', description VARCHAR(255) NOT NULL, tarif INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, status_id_id INT NOT NULL, contenu VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_BF5476CA9D86650F (user_id_id), INDEX IDX_BF5476CA881ECFA7 (status_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objectif (id INT AUTO_INCREMENT NOT NULL, status_id_id INT NOT NULL, objectif VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E2F86851881ECFA7 (status_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, status_id_id INT NOT NULL, entreprise_id_id INT NOT NULL, nom VARCHAR(255) NOT NULL, duree VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', description VARCHAR(255) DEFAULT NULL, debut_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', fin_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_50159CA9881ECFA7 (status_id_id), INDEX IDX_50159CA9DAC5BE2B (entreprise_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rappel (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, rappel_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', contenu VARCHAR(255) NOT NULL, INDEX IDX_303A29C99D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recommandation (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, conseil VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suivi_journalier (id INT AUTO_INCREMENT NOT NULL, objectif_id_id INT NOT NULL, rappel_id_id INT NOT NULL, user_id_id INT NOT NULL, INDEX IDX_956A07D97258AF93 (objectif_id_id), INDEX IDX_956A07D9B4B78D97 (rappel_id_id), INDEX IDX_956A07D99D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, status_id_id INT NOT NULL, projet_id_id INT NOT NULL, employe_id_id INT NOT NULL, nom VARCHAR(255) NOT NULL, duree VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', description VARCHAR(255) DEFAULT NULL, debut_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', fin_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_93872075881ECFA7 (status_id_id), INDEX IDX_93872075D4E271E1 (projet_id_id), INDEX IDX_93872075325980C0 (employe_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, numtel VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBDAC5BE2B FOREIGN KEY (entreprise_id_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBD9B357CE FOREIGN KEY (formule_id_id) REFERENCES formule (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC727ACA70 FOREIGN KEY (parent_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCE0894996 FOREIGN KEY (tache_id_id) REFERENCES tache (id)');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B99D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B9DAC5BE2B FOREIGN KEY (entreprise_id_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE entreprise ADD CONSTRAINT FK_D19FA609D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE objectif ADD CONSTRAINT FK_E2F86851881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9DAC5BE2B FOREIGN KEY (entreprise_id_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE rappel ADD CONSTRAINT FK_303A29C99D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE suivi_journalier ADD CONSTRAINT FK_956A07D97258AF93 FOREIGN KEY (objectif_id_id) REFERENCES objectif (id)');
        $this->addSql('ALTER TABLE suivi_journalier ADD CONSTRAINT FK_956A07D9B4B78D97 FOREIGN KEY (rappel_id_id) REFERENCES rappel (id)');
        $this->addSql('ALTER TABLE suivi_journalier ADD CONSTRAINT FK_956A07D99D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075881ECFA7 FOREIGN KEY (status_id_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075D4E271E1 FOREIGN KEY (projet_id_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075325980C0 FOREIGN KEY (employe_id_id) REFERENCES employe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBDAC5BE2B');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBD9B357CE');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC9D86650F');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC727ACA70');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCE0894996');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B99D86650F');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B9DAC5BE2B');
        $this->addSql('ALTER TABLE entreprise DROP FOREIGN KEY FK_D19FA609D86650F');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA9D86650F');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA881ECFA7');
        $this->addSql('ALTER TABLE objectif DROP FOREIGN KEY FK_E2F86851881ECFA7');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9881ECFA7');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9DAC5BE2B');
        $this->addSql('ALTER TABLE rappel DROP FOREIGN KEY FK_303A29C99D86650F');
        $this->addSql('ALTER TABLE suivi_journalier DROP FOREIGN KEY FK_956A07D97258AF93');
        $this->addSql('ALTER TABLE suivi_journalier DROP FOREIGN KEY FK_956A07D9B4B78D97');
        $this->addSql('ALTER TABLE suivi_journalier DROP FOREIGN KEY FK_956A07D99D86650F');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075881ECFA7');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075D4E271E1');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075325980C0');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE formule');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE objectif');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE rappel');
        $this->addSql('DROP TABLE recommandation');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE suivi_journalier');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
