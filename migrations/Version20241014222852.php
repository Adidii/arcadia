<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241014222852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Corrige le problème de séquence et de clé primaire pour la table service';
    }

    public function up(Schema $schema): void
    {
        // Supprime la séquence uniquement si elle existe
        $this->addSql("
            DO $$
            BEGIN
                IF EXISTS (SELECT 1 FROM pg_class WHERE relname = 'service_id_service_seq') THEN
                    DROP SEQUENCE service_id_service_seq CASCADE;
                END IF;
            END $$;
        ");

        // Crée la séquence uniquement si elle n'existe pas
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_class WHERE relname = 'service_id_seq') THEN
                    CREATE SEQUENCE service_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
                END IF;
            END $$;
        ");

        // Vérifie si la colonne `id_service` existe avant de la renommer
        $this->addSql("
            DO $$
            BEGIN
                IF EXISTS (
                    SELECT 1
                    FROM information_schema.columns
                    WHERE table_name = 'service' AND column_name = 'id_service'
                ) THEN
                    ALTER TABLE service RENAME COLUMN id_service TO id;
                END IF;
            END $$;
        ");

        // Vérifie si la clé primaire est déjà définie sur `id`
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM pg_constraint
                    WHERE conname = 'service_pkey'
                ) THEN
                    ALTER TABLE service ADD PRIMARY KEY (id);
                END IF;
            END $$;
        ");
    }

    public function down(Schema $schema): void
    {
        // Supprime la séquence uniquement si elle existe
        $this->addSql("
            DO $$
            BEGIN
                IF EXISTS (SELECT 1 FROM pg_class WHERE relname = 'service_id_seq') THEN
                    DROP SEQUENCE service_id_seq CASCADE;
                END IF;
            END $$;
        ");

        // Crée l'ancienne séquence uniquement si elle n'existe pas
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_class WHERE relname = 'service_id_service_seq') THEN
                    CREATE SEQUENCE service_id_service_seq INCREMENT BY 1 MINVALUE 1 START 1;
                END IF;
            END $$;
        ");

        // Vérifie si la colonne `id` existe avant de la renommer
        $this->addSql("
            DO $$
            BEGIN
                IF EXISTS (
                    SELECT 1
                    FROM information_schema.columns
                    WHERE table_name = 'service' AND column_name = 'id'
                ) THEN
                    ALTER TABLE service RENAME COLUMN id TO id_service;
                END IF;
            END $$;
        ");

        // Réinitialise la clé primaire sur `id_service`
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM pg_constraint
                    WHERE conname = 'service_pkey'
                ) THEN
                    ALTER TABLE service ADD PRIMARY KEY (id_service);
                END IF;
            END $$;
        ");
    }
}
