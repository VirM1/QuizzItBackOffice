<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220519143454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questions_reponse_module_thematique DROP FOREIGN KEY FK_660655294DBECD2AFC2B591FB88E14F');
        $this->addSql('ALTER TABLE reponses_reponse_module_thematique DROP FOREIGN KEY FK_CC31B36094DBECD2AFC2B591FB88E14F');
        $this->addSql('DROP INDEX FK_660655294DBECD2AFC2B591FB88E14F ON questions_reponse_module_thematique');
        $this->addSql('ALTER TABLE questions_reponse_module_thematique CHANGE date_creation date_creation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reponse_module_thematique CHANGE date_creation date_creation VARCHAR(255) NOT NULL');

        $this->addSql('ALTER TABLE questions_reponse_module_thematique ADD CONSTRAINT FK_660655294DBECD2AFC2B591FB88E14F FOREIGN KEY (utilisateur_id,module_id,date_creation) REFERENCES reponse_module_thematique (utilisateur_id,module_id,date_creation)');
        $this->addSql('DROP INDEX FK_CC31B36094DBECD2AFC2B591FB88E14F ON reponses_reponse_module_thematique');
        $this->addSql('ALTER TABLE reponses_reponse_module_thematique CHANGE date_creation date_creation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reponses_reponse_module_thematique ADD CONSTRAINT FK_CC31B36094DBECD2AFC2B591FB88E14F FOREIGN KEY (module_id, utilisateur_id,date_creation) REFERENCES reponse_module_thematique (module_id, utilisateur_id,date_creation)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questions_reponse_module_thematique DROP FOREIGN KEY FK_660655294DBECD2AFC2B591FB88E14F');
        $this->addSql('ALTER TABLE questions_reponse_module_thematique CHANGE date_creation date_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE questions_reponse_module_thematique ADD CONSTRAINT FK_660655294DBECD2AFC2B591FB88E14F FOREIGN KEY (module_id, utilisateur_id, date_creation) REFERENCES reponse_module_thematique (module_id, utilisateur_id, date_creation)');
        $this->addSql('CREATE INDEX FK_660655294DBECD2AFC2B591FB88E14F ON questions_reponse_module_thematique (module_id, utilisateur_id, date_creation)');
        $this->addSql('ALTER TABLE reponse_module_thematique CHANGE date_creation date_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reponses_reponse_module_thematique DROP FOREIGN KEY FK_CC31B36094DBECD2AFC2B591FB88E14F');
        $this->addSql('ALTER TABLE reponses_reponse_module_thematique CHANGE date_creation date_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reponses_reponse_module_thematique ADD CONSTRAINT FK_CC31B36094DBECD2AFC2B591FB88E14F FOREIGN KEY (module_id, utilisateur_id, date_creation) REFERENCES reponse_module_thematique (module_id, utilisateur_id, date_creation)');
        $this->addSql('CREATE INDEX FK_CC31B36094DBECD2AFC2B591FB88E14F ON reponses_reponse_module_thematique (module_id, utilisateur_id, date_creation)');
    }
}
