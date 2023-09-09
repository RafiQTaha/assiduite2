<?php

namespace App\Entity;

use App\Repository\ExControleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExControleRepository::class)]
class ExControle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: AcElement::class, inversedBy: 'controles')]
    private $element;

    #[ORM\ManyToOne(targetEntity: AcAnnee::class, inversedBy: 'controles')]
    private $annee;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $mcc = 0;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $mtp = 0;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $mef = 0;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $efr = 0;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $ccr = 0;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $tpr = 0;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $melement = 0;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $mmodule = 0;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $msemestre = 0;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $mannee = 0;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $observation;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $active = 1;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $simulation = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getElement(): ?AcElement
    {
        return $this->element;
    }

    public function setElement(?AcElement $element): self
    {
        $this->element = $element;

        return $this;
    }

    public function getAnnee(): ?AcAnnee
    {
        return $this->annee;
    }

    public function setAnnee(?AcAnnee $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getMcc(): ?bool
    {
        return $this->mcc;
    }

    public function setMcc(?bool $mcc): self
    {
        $this->mcc = $mcc;

        return $this;
    }

    public function getMtp(): ?bool
    {
        return $this->mtp;
    }

    public function setMtp(?bool $mtp): self
    {
        $this->mtp = $mtp;

        return $this;
    }

    public function getMef(): ?bool
    {
        return $this->mef;
    }

    public function setMef(?bool $mef): self
    {
        $this->mef = $mef;

        return $this;
    }

    public function getEfr(): ?bool
    {
        return $this->efr;
    }

    public function setEfr(?bool $efr): self
    {
        $this->efr = $efr;

        return $this;
    }

    public function getCcr(): ?bool
    {
        return $this->ccr;
    }

    public function setCcr(?bool $ccr): self
    {
        $this->ccr = $ccr;

        return $this;
    }

    public function getTpr(): ?bool
    {
        return $this->tpr;
    }

    public function setTpr(?bool $tpr): self
    {
        $this->tpr = $tpr;

        return $this;
    }

    public function getMelement(): ?bool
    {
        return $this->melement;
    }

    public function setMelement(?bool $melement): self
    {
        $this->melement = $melement;

        return $this;
    }

    public function getMmodule(): ?bool
    {
        return $this->mmodule;
    }

    public function setMmodule(?bool $mmodule): self
    {
        $this->mmodule = $mmodule;

        return $this;
    }

    public function getMsemestre(): ?bool
    {
        return $this->msemestre;
    }

    public function setMsemestre(?bool $msemestre): self
    {
        $this->msemestre = $msemestre;

        return $this;
    }

    public function getMannee(): ?bool
    {
        return $this->mannee;
    }

    public function setMannee(?bool $mannee): self
    {
        $this->mannee = $mannee;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getSimulation(): ?bool
    {
        return $this->simulation;
    }

    public function setSimulation(?bool $simulation): self
    {
        $this->simulation = $simulation;

        return $this;
    }
}
