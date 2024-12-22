<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Consumption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'id_consommation')]
    private ?int $idConsommation = null;

    #[ORM\ManyToOne(targetEntity: Animal::class)]
    #[ORM\JoinColumn(nullable: false, name: 'id_animal_id', referencedColumnName: 'id')]
    private ?Animal $animal = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $nourriture = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?float $grammage = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $date = null;

    // Getters et setters

    public function getIdConsommation(): ?int
    {
        return $this->idConsommation;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): self
    {
        $this->animal = $animal;
        return $this;
    }

    public function getNourriture(): ?string
    {
        return $this->nourriture;
    }

    public function setNourriture(string $nourriture): self
    {
        $this->nourriture = $nourriture;
        return $this;
    }

    public function getGrammage(): ?float
    {
        return $this->grammage;
    }

    public function setGrammage(float $grammage): self
    {
        $this->grammage = $grammage;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }
}
