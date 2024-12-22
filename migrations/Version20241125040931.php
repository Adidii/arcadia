<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125040931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    public function up(Schema $schema): void
    {
        // Vérifier si la contrainte existante doit être remplacée
        $this->addSql('DO $$ BEGIN
            IF EXISTS (
                SELECT 1 FROM information_schema.table_constraints
                WHERE table_name = \'consultation\' AND constraint_name = \'fk_consultation_veterinarian_id\'
            ) THEN
                ALTER TABLE consultation DROP CONSTRAINT fk_consultation_veterinarian_id;
            END IF;
        END $$;');
    
        // Ajouter la contrainte de clé étrangère sur veterinarian_id
        $this->addSql('DO $$ BEGIN
            IF NOT EXISTS (
                SELECT 1 FROM information_schema.table_constraints
                WHERE table_name = \'consultation\' AND constraint_name = \'FK_964685A6F1CBAF4F\'
            ) THEN
                ALTER TABLE consultation ADD CONSTRAINT FK_964685A6F1CBAF4F FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
            END IF;
        END $$;');
    
        // Ajouter des colonnes supplémentaires si elles n'existent pas
        $this->addSql('ALTER TABLE consultation ADD COLUMN IF NOT EXISTS etat_sante TEXT');
        $this->addSql('ALTER TABLE consultation ADD COLUMN IF NOT EXISTS date_passage DATE');
    }
    

public function down(Schema $schema): void
{
    $this->addSql('DROP SEQUENCE IF EXISTS consultation_id_consultation_seq CASCADE');
    $this->addSql('DROP SEQUENCE IF EXISTS veterinarian_id_veterinaire_seq CASCADE');

    $this->addSql('ALTER TABLE veterinarian DROP COLUMN IF EXISTS nom');
    $this->addSql('ALTER TABLE veterinarian DROP COLUMN IF EXISTS email');
    $this->addSql('ALTER TABLE veterinarian RENAME COLUMN id_veterinaire TO id');
    $this->addSql('ALTER TABLE veterinarian RENAME COLUMN mot_de_passe TO name');
    $this->addSql('ALTER TABLE veterinarian DROP CONSTRAINT IF EXISTS veterinarian_pkey');
    $this->addSql('ALTER TABLE veterinarian ADD PRIMARY KEY (id)');

    $this->addSql('ALTER TABLE consultation DROP CONSTRAINT IF EXISTS FK_964685A6F1CBAF4F');
    $this->addSql('ALTER TABLE consultation DROP COLUMN IF EXISTS id_consultation');
    $this->addSql('ALTER TABLE consultation DROP COLUMN IF EXISTS id_veterinaire');
    $this->addSql('ALTER TABLE consultation DROP COLUMN IF EXISTS etat_sante');
    $this->addSql('ALTER TABLE consultation DROP COLUMN IF EXISTS date_passage');
}


}
