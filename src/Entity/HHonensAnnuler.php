<?php

namespace App\Entity;

use App\Repository\HHonensAnnulerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HHonensAnnulerRepository::class)]
class HHonensAnnuler
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nbr_heur;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $enseignant;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $seance;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $usercreated;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $bordereau;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $montant;

    #[ORM\Column(type: 'string', length: 2, nullable: true)]
    private $statut;

    #[ORM\Column(type: 'float', nullable: true)]
    private $annuler;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'float', nullable: true)]
    private $exept;

    #[ORM\Column(type: 'float', nullable: true)]
    private $nbrScRegroupe;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateReglement;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $UserAnnuled;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNbrHeur(): ?int
    {
        return $this->nbr_heur;
    }

    public function setNbrHeur(?int $nbr_heur): self
    {
        $this->nbr_heur = $nbr_heur;

        return $this;
    }

    public function getEnseignant(): ?int
    {
        return $this->enseignant;
    }

    public function setEnseignant(?int $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    public function getSeance(): ?int
    {
        return $this->seance;
    }

    public function setSeance(?int $seance): self
    {
        $this->seance = $seance;

        return $this;
    }

    public function getUserCreated(): ?int
    {
        return $this->usercreated;
    }

    public function setUserCreated(?int $usercreated): self
    {
        $this->created = $usercreated;

        return $this;
    }

    public function getBordereau(): ?int
    {
        return $this->bordereau;
    }

    public function setBordereau(?int $bordereau): self
    {
        $this->bordereau = $bordereau;

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getAnnuler(): ?float
    {
        return $this->annuler;
    }

    public function setAnnuler(?float $annuler): self
    {
        $this->annuler = $annuler;

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

    public function getExept(): ?float
    {
        return $this->exept;
    }

    public function setExept(?float $exept): self
    {
        $this->exept = $exept;

        return $this;
    }

    public function getNbrScRegroupe(): ?float
    {
        return $this->nbrScRegroupe;
    }

    public function setNbrScRegroupe(?float $nbrScRegroupe): self
    {
        $this->nbrScRegroupe = $nbrScRegroupe;

        return $this;
    }

    public function getDateReglement(): ?\DateTimeInterface
    {
        return $this->dateReglement;
    }

    public function setDateReglement(?\DateTimeInterface $dateReglement): self
    {
        $this->dateReglement = $dateReglement;

        return $this;
    }

    public function getUserAnnuled(): ?int
    {
        return $this->UserAnnuled;
    }

    public function setUserAnnuled(?int $UserAnnuled): self
    {
        $this->UserAnnuled = $UserAnnuled;

        return $this;
    }
}
