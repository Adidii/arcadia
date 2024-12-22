<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id; // L'id doit rester privé

    #[ORM\Column(type: 'string', length: 100)]
    private $nom;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'time')]
    private $horaire_ouverture;

    #[ORM\Column(type: 'time')]
    private $horaire_fermeture;

    // Ajouter un getter pour l'id
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getters et setters pour les autres propriétés

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHoraireOuverture(): ?\DateTimeInterface
    {
        return $this->horaire_ouverture;
    }

    public function setHoraireOuverture(\DateTimeInterface $horaire_ouverture): self
    {
        $this->horaire_ouverture = $horaire_ouverture;

        return $this;
    }

    public function getHoraireFermeture(): ?\DateTimeInterface
    {
        return $this->horaire_fermeture;
    }

    public function setHoraireFermeture(\DateTimeInterface $horaire_fermeture): self
    {
        $this->horaire_fermeture = $horaire_fermeture;

        return $this;
    }
}
