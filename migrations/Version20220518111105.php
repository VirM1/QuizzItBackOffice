<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220518111105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E809A8886');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E809A8886 FOREIGN KEY (bonne_reponse_id) REFERENCES reponse (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E809A8886');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E809A8886 FOREIGN KEY (bonne_reponse_id) REFERENCES reponse (id)');
    }
}
