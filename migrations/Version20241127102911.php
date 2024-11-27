<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241127102911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D31A36327F');
        $this->addSql('DROP INDEX IDX_A3C664D31A36327F ON subscription');
        $this->addSql('ALTER TABLE subscription DROP streemi_user_id');
        $this->addSql('ALTER TABLE subscription_history DROP INDEX UNIQ_54AF90D09A1887DC, ADD INDEX IDX_54AF90D09A1887DC (subscription_id)');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D01A36327F');
        $this->addSql('DROP INDEX IDX_54AF90D01A36327F ON subscription_history');
        $this->addSql('ALTER TABLE subscription_history ADD subscriber_id INT NOT NULL, DROP streemi_user_id, CHANGE subscription_id subscription_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D07808B1AD FOREIGN KEY (subscriber_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_54AF90D07808B1AD ON subscription_history (subscriber_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_history DROP INDEX IDX_54AF90D09A1887DC, ADD UNIQUE INDEX UNIQ_54AF90D09A1887DC (subscription_id)');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D07808B1AD');
        $this->addSql('DROP INDEX IDX_54AF90D07808B1AD ON subscription_history');
        $this->addSql('ALTER TABLE subscription_history ADD streemi_user_id INT DEFAULT NULL, DROP subscriber_id, CHANGE subscription_id subscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D01A36327F FOREIGN KEY (streemi_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_54AF90D01A36327F ON subscription_history (streemi_user_id)');
        $this->addSql('ALTER TABLE subscription ADD streemi_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D31A36327F FOREIGN KEY (streemi_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A3C664D31A36327F ON subscription (streemi_user_id)');
    }
}
