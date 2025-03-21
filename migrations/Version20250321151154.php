<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321151154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pvversion ADD test_id INT NOT NULL');
        $this->addSql('ALTER TABLE pvversion ADD CONSTRAINT FK_5EE543D11E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('CREATE INDEX IDX_5EE543D11E5D0459 ON pvversion (test_id)');
        $this->addSql('ALTER TABLE test CHANGE statuts status VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test CHANGE status statuts VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE pvversion DROP FOREIGN KEY FK_5EE543D11E5D0459');
        $this->addSql('DROP INDEX IDX_5EE543D11E5D0459 ON pvversion');
        $this->addSql('ALTER TABLE pvversion DROP test_id');
    }
}
