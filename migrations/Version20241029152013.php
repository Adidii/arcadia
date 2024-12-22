<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241029152013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de la colonne jour sans contrainte NOT NULL pour éviter les erreurs SQLSTATE[23502]';
    }

    public function up(Schema $schema): void
    {
        // Ajout de la colonne jour si elle n'existe pas
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM information_schema.columns
                    WHERE table_name = 'opening_and_closing_hours'
                      AND column_name = 'jour'
                ) THEN
                    ALTER TABLE opening_and_closing_hours ADD COLUMN jour VARCHAR(10) NULL;
                END IF;
            END $$;
        ");
    }

    public function down(Schema $schema): void
    {
        // Suppression de la colonne jour si elle existe
        $this->addSql("
            DO $$
            BEGIN
                IF EXISTS (
                    SELECT 1
                    FROM information_schema.columns
                    WHERE table_name = 'opening_and_closing_hours'
                      AND column_name = 'jour'
                ) THEN
                    ALTER TABLE opening_and_closing_hours DROP COLUMN jour;
                END IF;
            END $$;
        ");
    }
}
