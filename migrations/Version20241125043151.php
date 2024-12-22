<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration corrigée pour éviter l'ajout de colonnes déjà existantes.
 */
final class Version20241125043151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout conditionnel des colonnes et modifications de la table consultation et veterinarian';
    }

    public function up(Schema $schema): void
    {
        // Ajouter la colonne `etat_sante` uniquement si elle n'existe pas déjà
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM information_schema.columns
                    WHERE table_name = 'consultation' AND column_name = 'etat_sante'
                ) THEN
                    ALTER TABLE consultation ADD etat_sante TEXT DEFAULT NULL;
                END IF;
            END $$;
        ");

        // Ajouter la colonne `date_passage` uniquement si elle n'existe pas déjà
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM information_schema.columns
                    WHERE table_name = 'consultation' AND column_name = 'date_passage'
                ) THEN
                    ALTER TABLE consultation ADD date_passage DATE DEFAULT NULL;
                END IF;
            END $$;
        ");

        // Ajouter la colonne `nom` dans veterinarian uniquement si elle n'existe pas déjà
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM information_schema.columns
                    WHERE table_name = 'veterinarian' AND column_name = 'nom'
                ) THEN
                    ALTER TABLE veterinarian ADD nom VARCHAR(100) NOT NULL;
                END IF;
            END $$;
        ");

        // Ajouter la colonne `email` dans veterinarian uniquement si elle n'existe pas déjà
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM information_schema.columns
                    WHERE table_name = 'veterinarian' AND column_name = 'email'
                ) THEN
                    ALTER TABLE veterinarian ADD email VARCHAR(100) NOT NULL;
                END IF;
            END $$;
        ");

        // Renommer la colonne `name` en `mot_de_passe` si nécessaire
        $this->addSql("
            DO $$
            BEGIN
                IF EXISTS (
                    SELECT 1
                    FROM information_schema.columns
                    WHERE table_name = 'veterinarian' AND column_name = 'name'
                ) THEN
                    ALTER TABLE veterinarian RENAME COLUMN name TO mot_de_passe;
                END IF;
            END $$;
        ");

        // Créer un index unique sur `email` si ce n'est pas déjà fait
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM pg_class
                    WHERE relname = 'uniq_4e5c1805e7927c74'
                ) THEN
                    CREATE UNIQUE INDEX UNIQ_4E5C1805E7927C74 ON veterinarian (email);
                END IF;
            END $$;
        ");
    }

    public function down(Schema $schema): void
    {
        // Supprimer l'index unique sur `email`
        $this->addSql('DROP INDEX IF EXISTS UNIQ_4E5C1805E7927C74');

        // Supprimer les colonnes ajoutées
        $this->addSql('ALTER TABLE veterinarian DROP COLUMN IF EXISTS nom');
        $this->addSql('ALTER TABLE veterinarian DROP COLUMN IF EXISTS email');
        $this->addSql('ALTER TABLE veterinarian RENAME COLUMN mot_de_passe TO name IF EXISTS');
        $this->addSql('ALTER TABLE consultation DROP COLUMN IF EXISTS etat_sante');
        $this->addSql('ALTER TABLE consultation DROP COLUMN IF EXISTS date_passage');
    }
}
