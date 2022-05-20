<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220518135851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reponses_reponse_module_thematique (date_creation DATETIME NOT NULL, module_id INT NOT NULL, utilisateur_id INT NOT NULL, reponse_id INT NOT NULL, INDEX IDX_CC31B36094DBECD2AFC2B591FB88E14F (date_creation, module_id, utilisateur_id), INDEX IDX_CC31B360CF18BB82 (reponse_id), PRIMARY KEY(date_creation, module_id, utilisateur_id, reponse_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reponses_reponse_module_thematique ADD CONSTRAINT FK_CC31B36094DBECD2AFC2B591FB88E14F FOREIGN KEY (module_id, utilisateur_id,date_creation) REFERENCES reponse_module_thematique (module_id, utilisateur_id,date_creation)');
        $this->addSql('ALTER TABLE reponses_reponse_module_thematique ADD CONSTRAINT FK_CC31B360CF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reponses_reponse_module_thematique');
    }
}
