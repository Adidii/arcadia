<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class OpeningAndClosingHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id_horaire;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $jour;
    
    #[ORM\Column(type: 'time')]
    private $ouverture;

    #[ORM\Column(type: 'time')]
    private $fermeture;

    // Getter for id_horaire
    public function getIdHoraire(): ?int
    {
        return $this->id_horaire;
    }

    // Getter and Setter for jour
    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;
        return $this;
    }

    // Getter for ouverture
    public function getOuverture(): ?\DateTimeInterface
    {
        return $this->ouverture;
    }

    public function setOuverture(\DateTimeInterface $ouverture): self
    {
        $this->ouverture = $ouverture;
        return $this;
    }

    // Getter for fermeture
    public function getFermeture(): ?\DateTimeInterface
    {
        return $this->fermeture;
    }

    public function setFermeture(\DateTimeInterface $fermeture): self
    {
        $this->fermeture = $fermeture;
        return $this;
    }
}
