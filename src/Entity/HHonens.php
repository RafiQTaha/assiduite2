<?php

namespace App\Entity;

use App\Repository\HHonensRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HHonensRepository::class)]
class HHonens
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\ManyToOne(targetEntity: PEnseignant::class, inversedBy: 'honens')]
    private $enseignant;

    #[ORM\ManyToOne(targetEntity: PlEmptime::class, inversedBy: 'honens')]
    private $seance;

    #[ORM\Column(type: 'float', nullable: true)]
    private $nbrHeur;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $montant;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private $statut = "E";

    #[ORM\Column(type: 'float', nullable: true)]
    private $annuler = 0;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $annulated;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'honenss')]
    private $userCreated;

    #[ORM\ManyToOne(targetEntity: HAlbhon::class, inversedBy: 'honenss')]
    private $bordereau;

    #[ORM\Column(type: 'float', nullable: true)]
    private $exept = 0;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nbrScRegroupe = 1;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateReglement;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Brut;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Ir;

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

    public function getEnseignant(): ?PEnseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?PEnseignant $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
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

    public function getNbrHeur(): ?float
    {
        return $this->nbrHeur;
    }

    public function setNbrHeur(?float $nbrHeur): self
    {
        $this->nbrHeur = $nbrHeur;

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

    public function getAnnulated(): ?\DateTimeInterface
    {
        return $this->annulated;
    }

    public function setAnnulated(?\DateTimeInterface $annulated): self
    {
        $this->annulated = $annulated;

        return $this;
    }

    public function getUserCreated(): ?User
    {
        return $this->userCreated;
    }

    public function setUserCreated(?User $userCreated): self
    {
        $this->userCreated = $userCreated;

        return $this;
    }

    public function getBordereau(): ?HAlbhon
    {
        return $this->bordereau;
    }

    public function setBordereau(?HAlbhon $bordereau): self
    {
        $this->bordereau = $bordereau;

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

    public function getNbrScRegroupe(): ?int
    {
        return $this->nbrScRegroupe;
    }

    public function setNbrScRegroupe(?int $nbrScRegroupe): self
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

    public function getBrut(): ?int
    {
        return $this->Brut;
    }

    public function setBrut(?int $Brut): self
    {
        $this->Brut = $Brut;

        return $this;
    }

    public function getIr(): ?int
    {
        return $this->Ir;
    }

    public function setIr(?int $Ir): self
    {
        $this->Ir = $Ir;

        return $this;
    }
}
