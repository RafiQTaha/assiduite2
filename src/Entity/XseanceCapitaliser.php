<?php

namespace App\Entity;

use App\Repository\XseanceCapitaliserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XseanceCapitaliserRepository::class)]
class XseanceCapitaliser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Admission;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Promotion;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Module;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Semestre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Année;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $Date_Sys;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIDAdmission(): ?string
    {
        return $this->ID_Admission;
    }

    public function setIDAdmission(?string $ID_Admission): self
    {
        $this->ID_Admission = $ID_Admission;

        return $this;
    }

    public function getIDPromotion(): ?string
    {
        return $this->ID_Promotion;
    }

    public function setIDPromotion(?string $ID_Promotion): self
    {
        $this->ID_Promotion = $ID_Promotion;

        return $this;
    }

    public function getIDModule(): ?string
    {
        return $this->ID_Module;
    }

    public function setIDModule(?string $ID_Module): self
    {
        $this->ID_Module = $ID_Module;

        return $this;
    }

    public function getIDSemestre(): ?string
    {
        return $this->ID_Semestre;
    }

    public function setIDSemestre(?string $ID_Semestre): self
    {
        $this->ID_Semestre = $ID_Semestre;

        return $this;
    }

    public function getIDAnnée(): ?string
    {
        return $this->ID_Année;
    }

    public function setIDAnnée(?string $ID_Année): self
    {
        $this->ID_Année = $ID_Année;

        return $this;
    }

    public function getDateSys(): ?\DateTimeInterface
    {
        return $this->Date_Sys;
    }

    public function setDateSys(?\DateTimeInterface $Date_Sys): self
    {
        $this->Date_Sys = $Date_Sys;

        return $this;
    }
}
