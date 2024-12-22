<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240924130212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Correction de la table users et séquences, création des tables nécessaires.';
    }

    public function up(Schema $schema): void
    {
        // Suppression conditionnelle de séquences existantes
        $this->addSql("
            DO $$
            BEGIN
                IF EXISTS (SELECT 1 FROM pg_class WHERE relname = 'user_id_utilisateur_seq') THEN
                    DROP SEQUENCE user_id_utilisateur_seq CASCADE;
                END IF;
            END $$;
        ");

        // Création conditionnelle de séquences
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_class WHERE relname = 'users_id_utilisateur_seq') THEN
                    CREATE SEQUENCE users_id_utilisateur_seq INCREMENT BY 1 MINVALUE 1 START 1;
                END IF;
            END $$;
        ");

        // Création des tables
        $this->addSql("
            CREATE TABLE IF NOT EXISTS users (
                id_utilisateur INT NOT NULL,
                nom VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                mot_de_passe VARCHAR(255) NOT NULL,
                role JSON NOT NULL,
                is_verified BOOLEAN NOT NULL,
                PRIMARY KEY (id_utilisateur)
            )
        ");

        $this->addSql("
            CREATE TABLE IF NOT EXISTS administrator (
                id_admin INT NOT NULL,
                nom VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                mot_de_passe VARCHAR(255) NOT NULL,
                PRIMARY KEY (id_admin)
            )
        ");

        $this->addSql("
            CREATE TABLE IF NOT EXISTS animal (
                id INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                PRIMARY KEY (id)
            )
        ");

        $this->addSql("
            CREATE TABLE IF NOT EXISTS animal_image (
                id_image INT NOT NULL,
                id_animal_id INT NOT NULL,
                url VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                PRIMARY KEY (id_image)
            )
        ");

        $this->addSql("
            CREATE TABLE IF NOT EXISTS consultation (
                id INT NOT NULL,
                veterinarian_id INT NOT NULL,
                PRIMARY KEY (id)
            )
        ");

        $this->addSql("
            CREATE TABLE IF NOT EXISTS employee (
                id_employe INT NOT NULL,
                nom VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                mot_de_passe VARCHAR(255) NOT NULL,
                role VARCHAR(50) NOT NULL,
                CHECK (role IN ('employe', 'veterinaire')),
                PRIMARY KEY (id_employe)
            )
        ");

        // Ajout des contraintes de clés étrangères (sans IF NOT EXISTS)
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM information_schema.constraint_column_usage
                    WHERE table_name = 'animal_image' AND constraint_name = 'fk_animal_image_id_animal'
                ) THEN
                    ALTER TABLE animal_image ADD CONSTRAINT fk_animal_image_id_animal FOREIGN KEY (id_animal_id) REFERENCES animal (id);
                END IF;
            END $$;
        ");

        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1
                    FROM information_schema.constraint_column_usage
                    WHERE table_name = 'consultation' AND constraint_name = 'fk_consultation_veterinarian_id'
                ) THEN
                    ALTER TABLE consultation ADD CONSTRAINT fk_consultation_veterinarian_id FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id);
                END IF;
            END $$;
        ");
    }

    public function down(Schema $schema): void
    {
        // Suppression des séquences
        $this->addSql("DROP SEQUENCE IF EXISTS users_id_utilisateur_seq CASCADE");

        // Suppression des tables
        $tables = [
            'users',
            'administrator',
            'animal',
            'animal_image',
            'consultation',
            'employee',
        ];

        foreach ($tables as $table) {
            $this->addSql("DROP TABLE IF EXISTS $table CASCADE");
        }
    }
}
