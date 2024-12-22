<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "consultation")]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'id')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Veterinarian::class)]
    #[ORM\JoinColumn(name: 'veterinarian_id', referencedColumnName: 'id_veterinaire', nullable: false)]
    private ?Veterinarian $veterinarian = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $etatSante = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $datePassage = null;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVeterinarian(): ?Veterinarian
    {
        return $this->veterinarian;
    }

    public function setVeterinarian(?Veterinarian $veterinarian): self
    {
        $this->veterinarian = $veterinarian;
        return $this;
    }

    public function getEtatSante(): ?string
    {
        return $this->etatSante;
    }

    public function setEtatSante(?string $etatSante): self
    {
        $this->etatSante = $etatSante;
        return $this;
    }

    public function getDatePassage(): ?\DateTimeInterface
    {
        return $this->datePassage;
    }

    public function setDatePassage(?\DateTimeInterface $datePassage): self
    {
        $this->datePassage = $datePassage;
        return $this;
    }
}
