<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "veterinarian")]
class Veterinarian
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_veterinaire", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "mot_de_passe", type: "string", length: 255, nullable: false)]
    private ?string $motDePasse = null;

    #[ORM\Column(type: "string", length: 100, nullable: false)]
    private ?string $nom = null;

    #[ORM\Column(type: "string", length: 100, nullable: false, unique: true)]
    private ?string $email = null;

    /**
     * Retourne une représentation textuelle de l'objet.
     */
    public function __toString(): string
    {
        return $this->nom ?? 'Veterinarian';
    }

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
}
