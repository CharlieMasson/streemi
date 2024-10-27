<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241004151019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // up
        $this->addSql('ALTER TABLE category CHANGE nom name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE language CHANGE nom name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE media ADD discr VARCHAR(255) NOT NULL');
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
        // down
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FBF396750');
        $this->addSql('ALTER TABLE movie ADD media_id INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D5EF26FEA9FDD75 ON movie (media_id)');
        $this->addSql('ALTER TABLE category CHANGE name nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE media DROP discr');
        $this->addSql('ALTER TABLE language CHANGE name nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334BF396750');
        $this->addSql('ALTER TABLE serie ADD media_id INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA3A9334EA9FDD75 ON serie (media_id)');
    }
}
