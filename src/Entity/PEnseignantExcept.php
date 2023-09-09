<?php

namespace App\Entity;

use App\Repository\PEnseignantExceptRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PEnseignantExceptRepository::class)]
class PEnseignantExcept
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PEnseignant::class, inversedBy: 'enseignantexcepts')]
    private $enseignant;

    #[ORM\ManyToOne(targetEntity: AcFormation::class, inversedBy: 'enseignantexcepts')]
    private $formation;

    #[ORM\Column(type: 'datetime')]
    private $created;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'enseignantexcepts')]
    private $usercreated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnseignant(): ?PEnseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?PEnseignant $enseignant): self
    {
        $this->enseignant = $enseignant;

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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
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
}
