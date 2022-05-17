<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517131450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE questions_reponse_module_thematique (question_id INT NOT NULL, date_creation DATETIME NOT NULL, module_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_66065521E27F6BF (question_id), INDEX IDX_660655294DBECD2AFC2B591FB88E14F (date_creation, module_id, utilisateur_id), PRIMARY KEY(question_id, date_creation, module_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questions_reponse_module_thematique ADD CONSTRAINT FK_66065521E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions_reponse_module_thematique ADD CONSTRAINT FK_660655294DBECD2AFC2B591FB88E14F FOREIGN KEY (module_id, utilisateur_id,date_creation) REFERENCES reponse_module_thematique (module_id, utilisateur_id,date_creation)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE questions_reponse_module_thematique');
    }
}
