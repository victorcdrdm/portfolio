<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210413101143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_technology (project_id INT NOT NULL, technology_id INT NOT NULL, INDEX IDX_ECC5297F166D1F9C (project_id), INDEX IDX_ECC5297F4235D463 (technology_id), PRIMARY KEY(project_id, technology_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_technology (user_id INT NOT NULL, technology_id INT NOT NULL, INDEX IDX_530494A1A76ED395 (user_id), INDEX IDX_530494A14235D463 (technology_id), PRIMARY KEY(user_id, technology_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_technology ADD CONSTRAINT FK_ECC5297F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_technology ADD CONSTRAINT FK_ECC5297F4235D463 FOREIGN KEY (technology_id) REFERENCES technology (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_technology ADD CONSTRAINT FK_530494A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_technology ADD CONSTRAINT FK_530494A14235D463 FOREIGN KEY (technology_id) REFERENCES technology (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article ADD project_id INT DEFAULT NULL, ADD picture VARCHAR(255) NOT NULL, ADD text LONGTEXT DEFAULT NULL, ADD update_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66166D1F9C ON article (project_id)');
        $this->addSql('ALTER TABLE education ADD name VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD school_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE picture ADD picture VARCHAR(255) NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD name VARCHAR(255) NOT NULL, ADD team VARCHAR(255) NOT NULL, ADD client VARCHAR(255) NOT NULL, ADD logo_client VARCHAR(255) DEFAULT NULL, ADD first_picture VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT NOT NULL, ADD link VARCHAR(255) DEFAULT NULL, ADD update_at DATETIME DEFAULT NULL, ADD show_project TINYINT(1) DEFAULT NULL, ADD period DATE DEFAULT NULL, ADD period_end DATE DEFAULT NULL, ADD int_time INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD name VARCHAR(255) NOT NULL, ADD logo VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE technology ADD name VARCHAR(255) NOT NULL, ADD logo VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD picture_id INT DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, ADD job VARCHAR(255) DEFAULT NULL, ADD github VARCHAR(255) DEFAULT NULL, ADD linkedin VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(180) DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649EE45BDBF ON user (picture_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project_technology');
        $this->addSql('DROP TABLE user_technology');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66166D1F9C');
        $this->addSql('DROP INDEX IDX_23A0E66166D1F9C ON article');
        $this->addSql('ALTER TABLE article DROP project_id, DROP picture, DROP text, DROP update_at');
        $this->addSql('ALTER TABLE education DROP name, DROP city, DROP school_name');
        $this->addSql('ALTER TABLE picture DROP picture, DROP updated_at');
        $this->addSql('ALTER TABLE project DROP name, DROP team, DROP client, DROP logo_client, DROP first_picture, DROP description, DROP link, DROP update_at, DROP show_project, DROP period, DROP period_end, DROP int_time');
        $this->addSql('ALTER TABLE skill DROP name, DROP logo, DROP updated_at');
        $this->addSql('ALTER TABLE technology DROP name, DROP logo, DROP updated_at');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EE45BDBF');
        $this->addSql('DROP INDEX UNIQ_8D93D649EE45BDBF ON user');
        $this->addSql('ALTER TABLE user DROP picture_id, DROP city, DROP address, DROP description, DROP job, DROP github, DROP linkedin, DROP phone, CHANGE email email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
