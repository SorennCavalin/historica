<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220919082529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, age_id INT NOT NULL, nom VARCHAR(100) NOT NULL, INDEX IDX_3BAE0AA7CC80CD12 (age_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_pays (event_id INT NOT NULL, pays_id INT NOT NULL, INDEX IDX_2B54700571F7E88B (event_id), INDEX IDX_2B547005A6E44244 (pays_id), PRIMARY KEY(event_id, pays_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7CC80CD12 FOREIGN KEY (age_id) REFERENCES age (id)');
        $this->addSql('ALTER TABLE event_pays ADD CONSTRAINT FK_2B54700571F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_pays ADD CONSTRAINT FK_2B547005A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7CC80CD12');
        $this->addSql('ALTER TABLE event_pays DROP FOREIGN KEY FK_2B54700571F7E88B');
        $this->addSql('ALTER TABLE event_pays DROP FOREIGN KEY FK_2B547005A6E44244');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_pays');
    }
}
