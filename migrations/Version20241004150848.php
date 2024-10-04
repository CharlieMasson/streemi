<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241004150848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE nom name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE language CHANGE nom name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE media ADD casting JSON NOT NULL, ADD discr VARCHAR(255) NOT NULL, DROP m_cast, CHANGE short_description short_description LONGTEXT NOT NULL, CHANGE long_description long_description LONGTEXT NOT NULL, CHANGE release_date release_date DATETIME NOT NULL, CHANGE cover_image cover_image VARCHAR(255) NOT NULL, CHANGE staff staff JSON NOT NULL, CHANGE media_type title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FEA9FDD75');
        $this->addSql('DROP INDEX UNIQ_1D5EF26FEA9FDD75 ON movie');
        $this->addSql('ALTER TABLE movie DROP media_id, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FBF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334EA9FDD75');
        $this->addSql('DROP INDEX UNIQ_AA3A9334EA9FDD75 ON serie');
        $this->addSql('ALTER TABLE serie DROP media_id, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334BF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FBF396750');
        $this->addSql('ALTER TABLE movie ADD media_id INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D5EF26FEA9FDD75 ON movie (media_id)');
        $this->addSql('ALTER TABLE category CHANGE name nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE media ADD media_type VARCHAR(255) NOT NULL, ADD m_cast JSON DEFAULT NULL, DROP title, DROP casting, DROP discr, CHANGE short_description short_description VARCHAR(255) DEFAULT NULL, CHANGE long_description long_description LONGTEXT DEFAULT NULL, CHANGE release_date release_date DATE NOT NULL, CHANGE cover_image cover_image VARCHAR(255) DEFAULT NULL, CHANGE staff staff JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE language CHANGE name nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334BF396750');
        $this->addSql('ALTER TABLE serie ADD media_id INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA3A9334EA9FDD75 ON serie (media_id)');
    }
}
