<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241125042307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration pour renommer la colonne id en id_veterinaire, ajouter des colonnes nom et email et ajuster les clés étrangères.';
    }

    public function up(Schema $schema): void
    {
        // Supprimer les contraintes de clé étrangère existantes sur consultation
        $this->addSql('DO $$ BEGIN
            IF EXISTS (
                SELECT 1 
                FROM information_schema.table_constraints 
                WHERE table_name = \'consultation\' AND constraint_name = \'fk_964685a6804c8213\'
            ) THEN
                ALTER TABLE consultation DROP CONSTRAINT fk_964685a6804c8213;
            END IF;
        END $$;');

        $this->addSql('DO $$ BEGIN
            IF EXISTS (
                SELECT 1 
                FROM information_schema.table_constraints 
                WHERE table_name = \'consultation\' AND constraint_name = \'fk_964685a6f1cbaf4f\'
            ) THEN
                ALTER TABLE consultation DROP CONSTRAINT fk_964685a6f1cbaf4f;
            END IF;
        END $$;');

        // Supprimer la clé primaire existante sur veterinarian
        $this->addSql('DO $$ BEGIN
            IF EXISTS (
                SELECT 1 
                FROM information_schema.table_constraints 
                WHERE table_name = \'veterinarian\' AND constraint_name = \'veterinarian_pkey\'
            ) THEN
                ALTER TABLE veterinarian DROP CONSTRAINT veterinarian_pkey;
            END IF;
        END $$;');

        // Renommer les colonnes dans veterinarian
        $this->addSql('DO $$ BEGIN
            IF EXISTS (
                SELECT 1 
                FROM information_schema.columns 
                WHERE table_name = \'veterinarian\' AND column_name = \'id\'
            ) THEN
                ALTER TABLE veterinarian RENAME COLUMN id TO id_veterinaire;
            END IF;
        END $$;');

        $this->addSql('DO $$ BEGIN
            IF EXISTS (
                SELECT 1 
                FROM information_schema.columns 
                WHERE table_name = \'veterinarian\' AND column_name = \'name\'
            ) THEN
                ALTER TABLE veterinarian RENAME COLUMN name TO mot_de_passe;
            END IF;
        END $$;');

        // Ajouter les colonnes nom et email si elles n'existent pas
        $this->addSql('ALTER TABLE veterinarian ADD COLUMN IF NOT EXISTS nom VARCHAR(100)');
        $this->addSql('ALTER TABLE veterinarian ADD COLUMN IF NOT EXISTS email VARCHAR(100)');

        // Mettre des valeurs par défaut pour nom et email si nécessaire
        $this->addSql('UPDATE veterinarian SET nom = \'Default Name\' WHERE nom IS NULL');
        $this->addSql('UPDATE veterinarian SET email = \'default@example.com\' WHERE email IS NULL');

        // Appliquer les contraintes NOT NULL
        $this->addSql('ALTER TABLE veterinarian ALTER COLUMN nom SET NOT NULL');
        $this->addSql('ALTER TABLE veterinarian ALTER COLUMN email SET NOT NULL');

        // Réappliquer une nouvelle clé primaire sur id_veterinaire
        $this->addSql('ALTER TABLE veterinarian ADD PRIMARY KEY (id_veterinaire)');

        // Ajouter un index unique sur email
        $this->addSql('CREATE UNIQUE INDEX IF NOT EXISTS UNIQ_4E5C1805E7927C74 ON veterinarian (email)');

        // Réappliquer les contraintes de clé étrangère sur consultation
        $this->addSql('DO $$ BEGIN
            IF NOT EXISTS (
                SELECT 1 
                FROM information_schema.table_constraints 
                WHERE table_name = \'consultation\' AND constraint_name = \'fk_964685a6804c8213\'
            ) THEN
                ALTER TABLE consultation ADD CONSTRAINT FK_964685A6804C8213 FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id_veterinaire) NOT DEFERRABLE INITIALLY IMMEDIATE;
            END IF;
        END $$;');

        $this->addSql('DO $$ BEGIN
            IF NOT EXISTS (
                SELECT 1 
                FROM information_schema.table_constraints 
                WHERE table_name = \'consultation\' AND constraint_name = \'fk_964685a6f1cbaf4f\'
            ) THEN
                ALTER TABLE consultation ADD CONSTRAINT FK_964685A6F1CBAF4F FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id_veterinaire) NOT DEFERRABLE INITIALLY IMMEDIATE;
            END IF;
        END $$;');
    }

    public function down(Schema $schema): void
    {
        // Supprimer les contraintes de clé étrangère sur consultation
        $this->addSql('ALTER TABLE consultation DROP CONSTRAINT IF EXISTS FK_964685A6804C8213');
        $this->addSql('ALTER TABLE consultation DROP CONSTRAINT IF EXISTS FK_964685A6F1CBAF4F');

        // Supprimer la clé primaire actuelle sur veterinarian
        $this->addSql('ALTER TABLE veterinarian DROP CONSTRAINT IF EXISTS veterinarian_pkey');

        // Revenir aux colonnes d'origine dans veterinarian
        $this->addSql('ALTER TABLE veterinarian DROP COLUMN IF EXISTS nom');
        $this->addSql('ALTER TABLE veterinarian DROP COLUMN IF EXISTS email');
        $this->addSql('ALTER TABLE veterinarian RENAME COLUMN id_veterinaire TO id');
        $this->addSql('ALTER TABLE veterinarian RENAME COLUMN mot_de_passe TO name');

        // Réappliquer l'ancienne clé primaire
        $this->addSql('ALTER TABLE veterinarian ADD PRIMARY KEY (id)');

        // Réappliquer les anciennes contraintes de clé étrangère sur consultation
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6804C8213 FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6F1CBAF4F FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
