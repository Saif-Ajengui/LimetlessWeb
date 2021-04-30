<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210429164127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE participer');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE routineclient');
        $this->addSql('ALTER TABLE cour2 DROP FOREIGN KEY cour2_ibfk_1');
        $this->addSql('ALTER TABLE cour2 CHANGE idf idf INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cour2 ADD CONSTRAINT FK_FC11FD9A1D074373 FOREIGN KEY (idf) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE formation CHANGE effectif effectif INT NOT NULL');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY participants_ibfk_1');
        $this->addSql('ALTER TABLE participants CHANGE idclient idclient INT DEFAULT NULL, CHANGE idformation idformation INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_71697092A3F9A9F9 FOREIGN KEY (idclient) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE user CHANGE Date_naiss Date_naiss DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, idf INT DEFAULT NULL, nom VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, extension LONGBLOB NOT NULL, image LONGBLOB NOT NULL, INDEX idf (idf), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evenement (id_event INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(80) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_deb VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_fin VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_event)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participant (id_Participant INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom_evenement VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, sexe VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, statut VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, mail VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_Participant (id_Participant), PRIMARY KEY(id_Participant)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participer (id_event INT NOT NULL, id_Participant INT NOT NULL, reponseEvent VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, date_participation VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nb_participant INT NOT NULL, INDEX id_event (id_event, id_Participant), PRIMARY KEY(id_event, id_Participant)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, id_client INT NOT NULL, id_coach INT NOT NULL, date VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Email VARCHAR(30) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, typerec VARCHAR(110) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(110) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Email VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reponse (id INT NOT NULL, Reponse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, ID_Rep INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(ID_Rep)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE routineclient (idTache INT AUTO_INCREMENT NOT NULL, nomCoach VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nomClient VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nomTache VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, avancement VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, duree VARCHAR(5) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idTache)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C1D074373 FOREIGN KEY (idf) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE cour2 DROP FOREIGN KEY FK_FC11FD9A1D074373');
        $this->addSql('ALTER TABLE cour2 CHANGE idf idf INT NOT NULL');
        $this->addSql('ALTER TABLE cour2 ADD CONSTRAINT cour2_ibfk_1 FOREIGN KEY (idf) REFERENCES formation (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation CHANGE effectif effectif INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_71697092A3F9A9F9');
        $this->addSql('ALTER TABLE participants CHANGE idformation idformation INT NOT NULL, CHANGE idclient idclient INT NOT NULL');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT participants_ibfk_1 FOREIGN KEY (idclient) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE Date_naiss Date_naiss VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
