<?php

namespace App\Entity;

use App\Repository\PlEmptimensRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlEmptimensRepository::class)]
class PlEmptimens
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PlEmptime::class, inversedBy: 'emptimens')]
    private $seance;

    #[ORM\ManyToOne(targetEntity: PEnseignant::class, inversedBy: 'emptimens')]
    private $enseignant;

    #[ORM\Column(type: 'float', nullable: true)]
    private $generer;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $Created;

    #[ORM\Column(type: 'float', nullable: true)]
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeance(): ?PlEmptime
    {
        return $this->seance;
    }

    public function setSeance(?PlEmptime $seance): self
    {
        $this->seance = $seance;

        return $this;
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

    public function getGenerer(): ?float
    {
        return $this->generer;
    }

    public function setGenerer(?float $generer): self
    {
        $this->generer = $generer;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->Created;
    }

    public function setCreated(?\DateTimeInterface $Created): self
    {
        $this->Created = $Created;

        return $this;
    }

    public function getActive(): ?float
    {
        return $this->active;
    }

    public function setActive(?float $active): self
    {
        $this->active = $active;

        return $this;
    }
}
