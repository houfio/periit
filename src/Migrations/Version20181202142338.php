<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181202142338 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7CBE75955E237E06 (name), UNIQUE INDEX UNIQ_7CBE7595989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F99EDABB5E237E06 (name), UNIQUE INDEX UNIQ_F99EDABB989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school_levels (school_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_629667D5C32A47EE (school_id), INDEX IDX_629667D55FB14BA7 (level_id), PRIMARY KEY(school_id, level_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE method (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5E593A605E237E06 (name), UNIQUE INDEX UNIQ_5E593A60989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9AEACC135E237E06 (name), UNIQUE INDEX UNIQ_9AEACC13989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_person (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, telephone_private VARCHAR(20) NOT NULL, function VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A44EE6F7E7927C74 (email), INDEX IDX_A44EE6F7979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zip_code VARCHAR(6) NOT NULL, city VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zip_code VARCHAR(6) NOT NULL, city VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_4FBF094F5E237E06 (name), UNIQUE INDEX UNIQ_4FBF094F989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_levels (company_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_A2B5006C979B1AD6 (company_id), INDEX IDX_A2B5006C5FB14BA7 (level_id), PRIMARY KEY(company_id, level_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_materials (company_id INT NOT NULL, material_id INT NOT NULL, INDEX IDX_A80C9C45979B1AD6 (company_id), INDEX IDX_A80C9C45E308AC6F (material_id), PRIMARY KEY(company_id, material_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_methods (company_id INT NOT NULL, method_id INT NOT NULL, INDEX IDX_76B0EDBE979B1AD6 (company_id), INDEX IDX_76B0EDBE19883967 (method_id), PRIMARY KEY(company_id, method_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE school_levels ADD CONSTRAINT FK_629667D5C32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('ALTER TABLE school_levels ADD CONSTRAINT FK_629667D55FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE contact_person ADD CONSTRAINT FK_A44EE6F7979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_levels ADD CONSTRAINT FK_A2B5006C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_levels ADD CONSTRAINT FK_A2B5006C5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE company_materials ADD CONSTRAINT FK_A80C9C45979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_materials ADD CONSTRAINT FK_A80C9C45E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE company_methods ADD CONSTRAINT FK_76B0EDBE979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_methods ADD CONSTRAINT FK_76B0EDBE19883967 FOREIGN KEY (method_id) REFERENCES method (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company_materials DROP FOREIGN KEY FK_A80C9C45E308AC6F');
        $this->addSql('ALTER TABLE school_levels DROP FOREIGN KEY FK_629667D5C32A47EE');
        $this->addSql('ALTER TABLE company_methods DROP FOREIGN KEY FK_76B0EDBE19883967');
        $this->addSql('ALTER TABLE school_levels DROP FOREIGN KEY FK_629667D55FB14BA7');
        $this->addSql('ALTER TABLE company_levels DROP FOREIGN KEY FK_A2B5006C5FB14BA7');
        $this->addSql('ALTER TABLE contact_person DROP FOREIGN KEY FK_A44EE6F7979B1AD6');
        $this->addSql('ALTER TABLE company_levels DROP FOREIGN KEY FK_A2B5006C979B1AD6');
        $this->addSql('ALTER TABLE company_materials DROP FOREIGN KEY FK_A80C9C45979B1AD6');
        $this->addSql('ALTER TABLE company_methods DROP FOREIGN KEY FK_76B0EDBE979B1AD6');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE school_levels');
        $this->addSql('DROP TABLE method');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE contact_person');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_levels');
        $this->addSql('DROP TABLE company_materials');
        $this->addSql('DROP TABLE company_methods');
    }
}
