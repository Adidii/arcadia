<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241029154222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute la colonne jour à la table opening_and_closing_hours avec vérification de son existence.';
    }

    public function up(Schema $schema): void
    {
        // Ajout de la colonne jour si elle n'existe pas déjà
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM information_schema.columns
                    WHERE table_name = 'opening_and_closing_hours'
                      AND column_name = 'jour'
                ) THEN
                    ALTER TABLE opening_and_closing_hours ADD COLUMN jour VARCHAR(10) DEFAULT NULL;
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
