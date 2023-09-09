<?php

namespace App\Entity;

use App\Repository\SemainesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SemainesRepository::class)]
class Semaines
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $semaine;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $Dated;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $Datef;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Tranche;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Position;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $AnneéS;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSemaine(): ?int
    {
        return $this->semaine;
    }

    public function setSemaine(?int $semaine): self
    {
        $this->semaine = $semaine;

        return $this;
    }

    public function getDated(): ?string
    {
        return $this->Dated;
    }

    public function setDated(?string $Dated): self
    {
        $this->Dated = $Dated;

        return $this;
    }

    public function getDatef(): ?string
    {
        return $this->Datef;
    }

    public function setDatef(?string $Datef): self
    {
        $this->Datef = $Datef;

        return $this;
    }

    public function getTranche(): ?int
    {
        return $this->Tranche;
    }

    public function setTranche(?int $Tranche): self
    {
        $this->Tranche = $Tranche;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->Position;
    }

    public function setPosition(?string $Position): self
    {
        $this->Position = $Position;

        return $this;
    }

    public function getAnneéS(): ?string
    {
        return $this->AnneéS;
    }

    public function setAnneéS(?string $AnneéS): self
    {
        $this->AnneéS = $AnneéS;

        return $this;
    }
}
