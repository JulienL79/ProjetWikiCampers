<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240512191345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE availability (id_a INT AUTO_INCREMENT NOT NULL, start_date_a DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_date_a DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', day_price_a DOUBLE PRECISION NOT NULL, status_a TINYINT(1) NOT NULL, idVehicle INT DEFAULT NULL, INDEX IDX_3FB7A2BFB398F74 (idVehicle), PRIMARY KEY(id_a)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (idV INT AUTO_INCREMENT NOT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, vehicle_number VARCHAR(255) NOT NULL, PRIMARY KEY(idV)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BFB398F74 FOREIGN KEY (idVehicle) REFERENCES vehicle (idV)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BFB398F74');
        $this->addSql('DROP TABLE availability');
        $this->addSql('DROP TABLE vehicle');
    }
}
