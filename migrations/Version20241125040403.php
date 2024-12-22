<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241125040403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Met à jour la table consultation pour inclure des champs supplémentaires, modifier les relations et corriger la séquence.';
    }

    public function up(Schema $schema): void
    {
        // Ajouter la colonne id_veterinaire avec une valeur par défaut temporaire
        $this->addSql('ALTER TABLE consultation ADD id_veterinaire INT DEFAULT 1');
        
        // Mettre à jour les lignes existantes avec une valeur par défaut
        $this->addSql('UPDATE consultation SET id_veterinaire = 1 WHERE id_veterinaire IS NULL');
    
        // Appliquer la contrainte NOT NULL
        $this->addSql('ALTER TABLE consultation ALTER COLUMN id_veterinaire SET NOT NULL');
    
        // Ajouter les autres modifications de la table
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6F1CBAF4F FOREIGN KEY (id_veterinaire) REFERENCES veterinarian (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_964685A6F1CBAF4F ON consultation (id_veterinaire)');
    }
    

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE IF EXISTS consultation_id_consultation_seq CASCADE;');
        $this->addSql('CREATE SEQUENCE consultation_id_seq INCREMENT BY 1 MINVALUE 1 START 1;');

        $this->addSql('ALTER TABLE consultation DROP CONSTRAINT IF EXISTS FK_964685A64C9C96F2;');
        $this->addSql('ALTER TABLE consultation DROP CONSTRAINT IF EXISTS FK_964685A6F1CBAF4F;');
        $this->addSql('DROP INDEX IF EXISTS IDX_964685A64C9C96F2;');
        $this->addSql('DROP INDEX IF EXISTS IDX_964685A6F1CBAF4F;');

        $this->addSql('ALTER TABLE consultation ADD id INT NOT NULL;');
        $this->addSql('ALTER TABLE consultation ADD veterinarian_id INT NOT NULL;');
        $this->addSql('ALTER TABLE consultation DROP COLUMN IF EXISTS id_consultation;');
        $this->addSql('ALTER TABLE consultation DROP COLUMN IF EXISTS id_animal;');
        $this->addSql('ALTER TABLE consultation DROP COLUMN IF EXISTS id_veterinaire;');
        $this->addSql('ALTER TABLE consultation DROP COLUMN IF EXISTS etat_sante;');
        $this->addSql('ALTER TABLE consultation DROP COLUMN IF EXISTS date_passage;');

        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT IF NOT EXISTS fk_964685a6804c8213 FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id) NOT DEFERRABLE INITIALLY IMMEDIATE;');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_964685a6804c8213 ON consultation (veterinarian_id);');
        $this->addSql('ALTER TABLE consultation ADD PRIMARY KEY (id);');
    }
}
