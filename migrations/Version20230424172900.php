<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230424172900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE country_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tax_number_pattern_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tax_rate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE country (id INT NOT NULL, tax_rate_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5373C966FDD13F95 ON country (tax_rate_id)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tax_number_pattern (id INT NOT NULL, country_id INT NOT NULL, pattern VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2269AA6BF92F3E70 ON tax_number_pattern (country_id)');
        $this->addSql('CREATE TABLE tax_rate (id INT NOT NULL, value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C966FDD13F95 FOREIGN KEY (tax_rate_id) REFERENCES tax_rate (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tax_number_pattern ADD CONSTRAINT FK_2269AA6BF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE country_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tax_number_pattern_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tax_rate_id_seq CASCADE');
        $this->addSql('ALTER TABLE country DROP CONSTRAINT FK_5373C966FDD13F95');
        $this->addSql('ALTER TABLE tax_number_pattern DROP CONSTRAINT FK_2269AA6BF92F3E70');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE tax_number_pattern');
        $this->addSql('DROP TABLE tax_rate');
    }
}
