<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241221082548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration corrigée pour synchroniser le schéma de la base avec Doctrine';
    }

    public function up(Schema $schema): void
    {
        // Vérifie et supprime la séquence si elle n'est pas nécessaire
        $this->addSql("
            DO $$
            BEGIN
                IF EXISTS (SELECT 1 FROM pg_class WHERE relname = 'veterinarian_id_seq') THEN
                    DROP SEQUENCE veterinarian_id_seq CASCADE;
                END IF;
            END $$;
        ");

        // Vérifie et crée la séquence correcte si nécessaire
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_class WHERE relname = 'veterinarian_id_veterinaire_seq') THEN
                    CREATE SEQUENCE veterinarian_id_veterinaire_seq INCREMENT BY 1 MINVALUE 1 START 1;
                END IF;
            END $$;
        ");

        // Supprime l'ancienne contrainte sur `animal_image`
        $this->addSql("
            DO $$
            BEGIN
                IF EXISTS (
                    SELECT 1 
                    FROM pg_constraint 
                    WHERE conname = 'fk_animal_image_id_animal'
                ) THEN
                    ALTER TABLE animal_image DROP CONSTRAINT fk_animal_image_id_animal;
                END IF;
            END $$;
        ");

        // Supprime l'ancienne contrainte sur `consultation`
        $this->addSql("
            DO $$
            BEGIN
                IF EXISTS (
                    SELECT 1 
                    FROM pg_constraint 
                    WHERE conname = 'fk_964685a6f1cbaf4f'
                ) THEN
                    ALTER TABLE consultation DROP CONSTRAINT fk_964685a6f1cbaf4f;
                END IF;
            END $$;
        ");

        // Vérifie et supprime la colonne `id_animal` si elle existe
        $this->addSql("
            DO $$
            BEGIN
                IF EXISTS (
                    SELECT 1 
                    FROM information_schema.columns 
                    WHERE table_name = 'consultation' AND column_name = 'id_animal'
                ) THEN
                    ALTER TABLE consultation DROP COLUMN id_animal;
                END IF;
            END $$;
        ");
    }

    public function down(Schema $schema): void
    {
        // Restaurer la séquence vétérinaire si nécessaire
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_class WHERE relname = 'veterinarian_id_seq') THEN
                    CREATE SEQUENCE veterinarian_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
                END IF;
            END $$;
        ");

        // Supprimer la séquence vétérinaire corrigée
        $this->addSql("
            DO $$
            BEGIN
                IF EXISTS (SELECT 1 FROM pg_class WHERE relname = 'veterinarian_id_veterinaire_seq') THEN
                    DROP SEQUENCE veterinarian_id_veterinaire_seq CASCADE;
                END IF;
            END $$;
        ");

        // Ajouter la colonne `id_animal` dans consultation si nécessaire
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 
                    FROM information_schema.columns 
                    WHERE table_name = 'consultation' AND column_name = 'id_animal'
                ) THEN
                    ALTER TABLE consultation ADD id_animal INT NOT NULL;
                END IF;
            END $$;
        ");
    }
}
