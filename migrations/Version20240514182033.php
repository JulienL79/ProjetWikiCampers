<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514182033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BFB398F74');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BFB398F74 FOREIGN KEY (idVehicle) REFERENCES vehicle (idV) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BFB398F74');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BFB398F74 FOREIGN KEY (idVehicle) REFERENCES vehicle (idV)');
    }
}
