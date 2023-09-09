<?php

namespace App\Entity;

use App\Repository\PEnsgrilleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PEnsgrilleRepository::class)]
class PEnsgrille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PGrade::class, inversedBy: 'ensgrilles')]
    private $grade;

    #[ORM\ManyToOne(targetEntity: AcFormation::class, inversedBy: 'ensgrilles')]
    private $formation;

    #[ORM\ManyToOne(targetEntity: PNatureEpreuve::class, inversedBy: 'ensgrilles')]
    private $type_epreuve;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $montant;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ensgrilles')]
    private $usercreated;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $nature;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrade(): ?PGrade
    {
        return $this->grade;
    }

    public function setGrade(?PGrade $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getFormation(): ?AcFormation
    {
        return $this->formation;
    }

    public function setFormation(?AcFormation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getTypeEpreuve(): ?PNatureEpreuve
    {
        return $this->type_epreuve;
    }

    public function setTypeEpreuve(?PNatureEpreuve $type_epreuve): self
    {
        $this->type_epreuve = $type_epreuve;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUsercreated(): ?User
    {
        return $this->usercreated;
    }

    public function setUsercreated(?User $usercreated): self
    {
        $this->usercreated = $usercreated;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(?string $nature): self
    {
        $this->nature = $nature;

        return $this;
    }
}
