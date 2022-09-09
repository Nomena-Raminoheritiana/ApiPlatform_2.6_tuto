<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220908111312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE numero_user (numero_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D8A3A7E05D172A78 (numero_id), INDEX IDX_D8A3A7E0A76ED395 (user_id), PRIMARY KEY(numero_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE numero_user ADD CONSTRAINT FK_D8A3A7E05D172A78 FOREIGN KEY (numero_id) REFERENCES numero (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE numero_user ADD CONSTRAINT FK_D8A3A7E0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE numero_user DROP FOREIGN KEY FK_D8A3A7E05D172A78');
        $this->addSql('ALTER TABLE numero_user DROP FOREIGN KEY FK_D8A3A7E0A76ED395');
        $this->addSql('DROP TABLE numero_user');
    }
}
