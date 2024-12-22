<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240924122747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration pour renommer la table user en users et ajouter les séquences et tables manquantes avec vérification d’existence.';
    }

    public function up(Schema $schema): void
    {
        // Vérification et création des séquences si elles n'existent pas
        $sequences = [
            'administrator_id_admin_seq',
            'animal_id_seq',
            'animal_image_id_image_seq',
            'consultation_id_seq',
            'consumption_id_consommation_seq',
            'contact_id_contact_seq',
            'employee_id_employe_seq',
            'habitat_id_habitat_seq',
            'opening_and_closing_hours_id_horaire_seq',
            'review_id_seq',
            'service_id_service_seq',
            'test_entity_id_seq',
            'user_id_utilisateur_seq',
            'veterinarian_id_seq',
            'visitor_id_seq',
        ];

        foreach ($sequences as $sequence) {
            $this->addSql("
                DO $$
                BEGIN
                    IF NOT EXISTS (SELECT 1 FROM pg_class WHERE relkind = 'S' AND relname = '$sequence') THEN
                        CREATE SEQUENCE $sequence INCREMENT BY 1 MINVALUE 1 START 1;
                    END IF;
                END $$;
            ");
        }

        // Vérification et création des tables
        $tables = [
            'animal' => "
                CREATE TABLE animal (
                    id INT NOT NULL,
                    name VARCHAR(255) NOT NULL,
                    PRIMARY KEY(id)
                )
            ",
            'animal_image' => "
                CREATE TABLE animal_image (
                    id_image INT NOT NULL,
                    id_animal_id INT NOT NULL,
                    url VARCHAR(255) NOT NULL,
                    description TEXT NOT NULL,
                    PRIMARY KEY(id_image)
                )
            ",
            'consultation' => "
                CREATE TABLE consultation (
                    id INT NOT NULL,
                    veterinarian_id INT NOT NULL,
                    PRIMARY KEY(id)
                )
            ",
            'contact' => "
                CREATE TABLE contact (
                    id_contact INT NOT NULL,
                    nom VARCHAR(100) NOT NULL,
                    email VARCHAR(100) NOT NULL,
                    message TEXT NOT NULL,
                    date DATE NOT NULL,
                    PRIMARY KEY(id_contact)
                )
            ",
            'employee' => "
                CREATE TABLE employee (
                    id_employe INT NOT NULL,
                    nom VARCHAR(100) NOT NULL,
                    email VARCHAR(100) NOT NULL,
                    mot_de_passe VARCHAR(255) NOT NULL,
                    role VARCHAR(50) NOT NULL,
                    CHECK (role IN ('employe', 'veterinaire')),
                    PRIMARY KEY(id_employe)
                )
            ",
            'habitat' => "
                CREATE TABLE habitat (
                    id_habitat INT NOT NULL,
                    nom VARCHAR(100) NOT NULL,
                    description TEXT NOT NULL,
                    image_url VARCHAR(255) NOT NULL,
                    PRIMARY KEY(id_habitat)
                )
            ",
            'opening_and_closing_hours' => "
                CREATE TABLE opening_and_closing_hours (
                    id_horaire INT NOT NULL,
                    ouverture TIME(0) WITHOUT TIME ZONE NOT NULL,
                    fermeture TIME(0) WITHOUT TIME ZONE NOT NULL,
                    jour VARCHAR(10) DEFAULT NULL,
                    PRIMARY KEY(id_horaire)
                )
            ",
            'users' => "
                CREATE TABLE users (
                    id_utilisateur INT NOT NULL,
                    nom VARCHAR(100) NOT NULL,
                    email VARCHAR(100) NOT NULL,
                    mot_de_passe VARCHAR(255) NOT NULL,
                    role JSON NOT NULL,
                    is_verified BOOLEAN NOT NULL,
                    PRIMARY KEY(id_utilisateur)
                )
            ",
            'veterinarian' => "
                CREATE TABLE veterinarian (
                    id INT NOT NULL,
                    name VARCHAR(255) NOT NULL,
                    PRIMARY KEY(id)
                )
            ",
            'visitor' => "
                CREATE TABLE visitor (
                    id INT NOT NULL,
                    name VARCHAR(255) NOT NULL,
                    PRIMARY KEY(id)
                )
            ",
        ];

        foreach ($tables as $tableName => $tableSql) {
            $this->addSql("
                DO $$
                BEGIN
                    IF NOT EXISTS (SELECT 1 FROM information_schema.tables WHERE table_name = '$tableName') THEN
                        $tableSql;
                    END IF;
                END $$;
            ");
        }

        // Ajout des contraintes de clés étrangères si elles n'existent pas
        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 FROM pg_constraint
                    WHERE conname = 'fk_e4ceddabea39031'
                ) THEN
                    ALTER TABLE animal_image ADD CONSTRAINT FK_E4CEDDABEA39031 FOREIGN KEY (id_animal_id) REFERENCES animal (id);
                END IF;
            END $$;
        ");

        $this->addSql("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 FROM pg_constraint
                    WHERE conname = 'fk_964685a6804c8213'
                ) THEN
                    ALTER TABLE consultation ADD CONSTRAINT FK_964685A6804C8213 FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id);
                END IF;
            END $$;
        ");
    }

    public function down(Schema $schema): void
    {
        // Drop all tables and sequences
        $this->addSql('DROP TABLE IF EXISTS animal CASCADE');
        $this->addSql('DROP TABLE IF EXISTS animal_image CASCADE');
        $this->addSql('DROP TABLE IF EXISTS consultation CASCADE');
        $this->addSql('DROP TABLE IF EXISTS contact CASCADE');
        $this->addSql('DROP TABLE IF EXISTS employee CASCADE');
        $this->addSql('DROP TABLE IF EXISTS habitat CASCADE');
        $this->addSql('DROP TABLE IF EXISTS opening_and_closing_hours CASCADE');
        $this->addSql('DROP TABLE IF EXISTS users CASCADE');
        $this->addSql('DROP TABLE IF EXISTS veterinarian CASCADE');
        $this->addSql('DROP TABLE IF EXISTS visitor CASCADE');

        $sequences = [
            'administrator_id_admin_seq',
            'animal_id_seq',
            'animal_image_id_image_seq',
            'consultation_id_seq',
            'consumption_id_consommation_seq',
            'contact_id_contact_seq',
            'employee_id_employe_seq',
            'habitat_id_habitat_seq',
            'opening_and_closing_hours_id_horaire_seq',
            'review_id_seq',
            'service_id_service_seq',
            'test_entity_id_seq',
            'user_id_utilisateur_seq',
            'veterinarian_id_seq',
            'visitor_id_seq',
        ];

        foreach ($sequences as $sequence) {
            $this->addSql("DROP SEQUENCE IF EXISTS $sequence CASCADE");
        }
    }
}
