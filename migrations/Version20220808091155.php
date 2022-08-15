<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220808091155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gericht ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gericht ADD CONSTRAINT FK_FEA5192912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_FEA5192912469DE2 ON gericht (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gericht DROP FOREIGN KEY FK_FEA5192912469DE2');
        $this->addSql('DROP INDEX IDX_FEA5192912469DE2 ON gericht');
        $this->addSql('ALTER TABLE gericht DROP category_id');
    }
}
