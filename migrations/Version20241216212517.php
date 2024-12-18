<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241216212517 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE bottle (
          picture VARCHAR(255) DEFAULT NULL,
          id BINARY(16) NOT NULL,
          name VARCHAR(255) NOT NULL,
          estate_name VARCHAR(255) NOT NULL,
          type VARCHAR(255) NOT NULL,
          year INT NOT NULL,
          grape_varieties JSON NOT NULL,
          rate VARCHAR(2) NOT NULL,
          owner_id VARCHAR(255) NOT NULL,
          country VARCHAR(255) DEFAULT NULL,
          price DOUBLE PRECISION DEFAULT NULL,
          saved_at DATE NOT NULL,
          tasted_at DATE DEFAULT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER
        SET
          utf8mb4');
        $this->addSql('CREATE TABLE grape_variety (
          id BINARY(16) NOT NULL,
          name VARCHAR(255) NOT NULL,
          UNIQUE INDEX UNIQ_ECDE22675E237E06 (name),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER
        SET
          utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE bottle');
        $this->addSql('DROP TABLE grape_variety');
    }
}
