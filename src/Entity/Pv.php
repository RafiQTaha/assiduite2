<?php

namespace App\Entity;

use App\Repository\PvRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PvRepository::class)]
class Pv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\ManyToOne(targetEntity: AcSemestre::class, inversedBy: 'pvs')]
    private $semestre;

    #[ORM\ManyToOne(targetEntity: AcAnnee::class, inversedBy: 'pvs')]
    private $annee;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $president;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $coordonnateur;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $membres;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $docAsso;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'pvs')]
    private $userCreated;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'pvs')]
    private $userUpdated;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\Column(type: 'float', nullable: true)]
    private $active;

    #[ORM\Column(type: 'float', nullable: true)]
    private $seuilRachat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $observation;

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

    public function getSemestre(): ?AcSemestre
    {
        return $this->semestre;
    }

    public function setSemestre(?AcSemestre $semestre): self
    {
        $this->semestre = $semestre;

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

    public function getPresident(): ?string
    {
        return $this->president;
    }

    public function setPresident(?string $president): self
    {
        $this->president = $president;

        return $this;
    }

    public function getCoordonnateur(): ?string
    {
        return $this->coordonnateur;
    }

    public function setCoordonnateur(?string $coordonnateur): self
    {
        $this->coordonnateur = $coordonnateur;

        return $this;
    }

    public function getMembres(): ?string
    {
        return $this->membres;
    }

    public function setMembres(?string $membres): self
    {
        $this->membres = $membres;

        return $this;
    }

    public function getDocAsso(): ?string
    {
        return $this->docAsso;
    }

    public function setDocAsso(?string $docAsso): self
    {
        $this->docAsso = $docAsso;

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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUserUpdated(): ?User
    {
        return $this->userUpdated;
    }

    public function setUserUpdated(?User $userUpdated): self
    {
        $this->userUpdated = $userUpdated;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

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

    public function getSeuilRachat(): ?float
    {
        return $this->seuilRachat;
    }

    public function setSeuilRachat(?float $seuilRachat): self
    {
        $this->seuilRachat = $seuilRachat;

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
}
