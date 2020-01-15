<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200113105816 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE alert ADD story_id INT DEFAULT NULL, ADD taken_care TINYINT(1) NOT NULL, CHANGE status resolved TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE alert ADD CONSTRAINT FK_17FD46C1AA5D4036 FOREIGN KEY (story_id) REFERENCES story (id)');
        $this->addSql('CREATE INDEX IDX_17FD46C1AA5D4036 ON alert (story_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE alert DROP FOREIGN KEY FK_17FD46C1AA5D4036');
        $this->addSql('DROP INDEX IDX_17FD46C1AA5D4036 ON alert');
        $this->addSql('ALTER TABLE alert ADD status TINYINT(1) NOT NULL, DROP story_id, DROP resolved, DROP taken_care');
    }
}
