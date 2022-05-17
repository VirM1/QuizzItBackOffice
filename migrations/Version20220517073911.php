<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517073911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE module_thematique (id INT AUTO_INCREMENT NOT NULL, thematique_id INT NOT NULL, libelle_module_thematique VARCHAR(100) NOT NULL, INDEX IDX_AF6BFE35476556AF (thematique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, module_thematique_id INT NOT NULL, bonne_reponse_id INT DEFAULT NULL, titre_question VARCHAR(100) NOT NULL, note_question VARCHAR(255) DEFAULT NULL, aide_question VARCHAR(255) DEFAULT NULL, INDEX IDX_B6F7494E14BE9607 (module_thematique_id), UNIQUE INDEX UNIQ_B6F7494E809A8886 (bonne_reponse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, titre_reponse VARCHAR(100) NOT NULL, INDEX IDX_5FB6DEC71E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_module_thematique (date_creation DATETIME NOT NULL, module_id INT NOT NULL, utilisateur_id INT NOT NULL, date_validation DATETIME DEFAULT NULL, INDEX IDX_3DCFDFBAFC2B591 (module_id), INDEX IDX_3DCFDFBFB88E14F (utilisateur_id), PRIMARY KEY(module_id, utilisateur_id, date_creation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thematique (id INT AUTO_INCREMENT NOT NULL, libelle_thematique VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, token_utilisateur VARCHAR(255) DEFAULT NULL, nom_utilisateur VARCHAR(255) NOT NULL, prenom_utilisateur VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module_thematique ADD CONSTRAINT FK_AF6BFE35476556AF FOREIGN KEY (thematique_id) REFERENCES thematique (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E14BE9607 FOREIGN KEY (module_thematique_id) REFERENCES module_thematique (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E809A8886 FOREIGN KEY (bonne_reponse_id) REFERENCES reponse (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE reponse_module_thematique ADD CONSTRAINT FK_3DCFDFBAFC2B591 FOREIGN KEY (module_id) REFERENCES module_thematique (id)');
        $this->addSql('ALTER TABLE reponse_module_thematique ADD CONSTRAINT FK_3DCFDFBFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E14BE9607');
        $this->addSql('ALTER TABLE reponse_module_thematique DROP FOREIGN KEY FK_3DCFDFBAFC2B591');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71E27F6BF');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E809A8886');
        $this->addSql('ALTER TABLE module_thematique DROP FOREIGN KEY FK_AF6BFE35476556AF');
        $this->addSql('ALTER TABLE reponse_module_thematique DROP FOREIGN KEY FK_3DCFDFBFB88E14F');
        $this->addSql('DROP TABLE module_thematique');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE reponse_module_thematique');
        $this->addSql('DROP TABLE thematique');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
