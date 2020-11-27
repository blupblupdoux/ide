<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201127094729 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, gender VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birthday DATE DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, address_info LONGTEXT DEFAULT NULL, phone_home VARCHAR(255) DEFAULT NULL, phone_mobile VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, doctor VARCHAR(255) DEFAULT NULL, secu_nb VARCHAR(255) DEFAULT NULL, patient_info LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE patient');
    }
}
