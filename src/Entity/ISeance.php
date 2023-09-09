<?php

namespace App\Entity;

use App\Repository\ISeanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ISeanceRepository::class)]
class ISeance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PlEmptime::class, inversedBy: 'iSeances')]
    private $seance;

    #[ORM\ManyToOne(targetEntity: PEnseignant::class, inversedBy: 'iSeances')]
    private $enseignant;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $statut;

    public function __construct()
    {
        $this->seance = new ArrayCollection();
    }

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

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(?int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

}
