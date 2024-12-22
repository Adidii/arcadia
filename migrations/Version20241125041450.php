<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125041450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
{
    // Ajouter la contrainte de clé étrangère uniquement si elle n'existe pas
    $this->addSql('DO $$ BEGIN
        IF NOT EXISTS (
            SELECT 1 
            FROM information_schema.table_constraints
            WHERE table_name = \'consultation\' AND constraint_name = \'fk_964685a6f1cbaf4f\'
        ) THEN
            ALTER TABLE consultation ADD CONSTRAINT FK_964685A6F1CBAF4F FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
        END IF;
    END $$;');
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
        $this->addSql('ALTER TABLE consultation DROP CONSTRAINT FK_964685A6F1CBAF4F');
        $this->addSql('DROP INDEX IDX_964685A6F1CBAF4F');
        $this->addSql('ALTER TABLE consultation DROP etat_sante');
        $this->addSql('ALTER TABLE consultation DROP date_passage');
        $this->addSql('ALTER TABLE consultation RENAME COLUMN id_veterinaire TO veterinarian_id');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT fk_964685a6804c8213 FOREIGN KEY (veterinarian_id) REFERENCES veterinarian (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_964685a6804c8213 ON consultation (veterinarian_id)');
    }
}
