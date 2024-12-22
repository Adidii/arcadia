<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125041834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
{
    // Supprimer les contraintes qui dépendent de `veterinarian_pkey`
    $this->addSql('ALTER TABLE consultation DROP CONSTRAINT IF EXISTS FK_964685A6804C8213');
    $this->addSql('ALTER TABLE consultation DROP CONSTRAINT IF EXISTS FK_964685A6F1CBAF4F');

    // Supprimer la clé primaire existante
    $this->addSql('ALTER TABLE veterinarian DROP CONSTRAINT veterinarian_pkey');

    // Renommer et modifier les colonnes de la table `veterinarian`
    $this->addSql('ALTER TABLE veterinarian RENAME COLUMN id TO id_veterinaire');
    $this->addSql('ALTER TABLE veterinarian RENAME COLUMN name TO mot_de_passe');
    $this->addSql('ALTER TABLE veterinarian ADD COLUMN IF NOT EXISTS nom VARCHAR(100)');
    $this->addSql('ALTER TABLE veterinarian ADD COLUMN IF NOT EXISTS email VARCHAR(100)');

    // Ajouter des valeurs par défaut temporaires pour `nom` et `email`
    $this->addSql('UPDATE veterinarian SET nom = \'Default Name\' WHERE nom IS NULL');
    $this->addSql('UPDATE veterinarian SET email = \'default@example.com\' WHERE email IS NULL');

    // Appliquer les contraintes NOT NULL
    $this->addSql('ALTER TABLE veterinarian ALTER COLUMN nom SET NOT NULL');
    $this->addSql('ALTER TABLE veterinarian ALTER COLUMN email SET NOT NULL');

    // Réappliquer la clé primaire
    $this->addSql('ALTER TABLE veterinarian ADD PRIMARY KEY (id_veterinaire)');

    // Ajouter un index unique sur `email`
    $this->addSql('CREATE UNIQUE INDEX IF NOT EXISTS UNIQ_4E5C1805E7927C74 ON veterinarian (email)');

    // Réappliquer les contraintes de clé étrangère
    $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6804C8213 FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id_veterinaire) NOT DEFERRABLE INITIALLY IMMEDIATE');
    $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6F1CBAF4F FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id_veterinaire) NOT DEFERRABLE INITIALLY IMMEDIATE');

    // Ajouter les colonnes à la table `consultation`
    $this->addSql('ALTER TABLE consultation ADD COLUMN IF NOT EXISTS id_animal INT');
    $this->addSql('UPDATE consultation SET id_animal = 1 WHERE id_animal IS NULL'); // Remplacez `1` par un ID valide
    $this->addSql('ALTER TABLE consultation ALTER COLUMN id_animal SET NOT NULL');
    $this->addSql('ALTER TABLE consultation ADD COLUMN IF NOT EXISTS etat_sante TEXT NOT NULL');
    $this->addSql('ALTER TABLE consultation ADD COLUMN IF NOT EXISTS date_passage DATE NOT NULL');
}

       
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE veterinarian_id_veterinaire_seq CASCADE');
        $this->addSql('CREATE SEQUENCE veterinarian_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP INDEX UNIQ_4E5C1805E7927C74');
        $this->addSql('DROP INDEX veterinarian_pkey');
        $this->addSql('ALTER TABLE veterinarian DROP nom');
        $this->addSql('ALTER TABLE veterinarian DROP email');
        $this->addSql('ALTER TABLE veterinarian RENAME COLUMN id_veterinaire TO id');
        $this->addSql('ALTER TABLE veterinarian RENAME COLUMN mot_de_passe TO name');
        $this->addSql('ALTER TABLE veterinarian ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE consultation DROP id_animal');
        $this->addSql('ALTER TABLE consultation DROP etat_sante');
        $this->addSql('ALTER TABLE consultation DROP date_passage');
    }
}
