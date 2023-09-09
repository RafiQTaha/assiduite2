<?php

namespace App\Entity;

use App\Repository\ExMnotesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExMnotesRepository::class)]
class ExMnotes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: TInscription::class, inversedBy: 'mnotes')]
    private $inscription;

    #[ORM\ManyToOne(targetEntity: AcModule::class)]
    private $module;

    #[ORM\Column(type: 'float', nullable: true)]
    private $note;

    #[ORM\Column(type: 'float', nullable: true)]
    private $noteIni;

    #[ORM\Column(type: 'float', nullable: true)]
    private $noteRat;

    #[ORM\Column(type: 'float', nullable: true)]
    private $noteRachat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $observation;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user;

    #[ORM\ManyToOne(targetEntity: PeStatut::class)]
    private $statutS2;

    #[ORM\ManyToOne(targetEntity: PeStatut::class)]
    private $statutDef;

    #[ORM\ManyToOne(targetEntity: PeStatut::class)]
    private $statutAff;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInscription(): ?TInscription
    {
        return $this->inscription;
    }

    public function setInscription(?TInscription $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getModule(): ?AcModule
    {
        return $this->module;
    }

    public function setModule(?AcModule $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getNoteIni(): ?float
    {
        return $this->noteIni;
    }

    public function setNoteIni(?float $noteIni): self
    {
        $this->noteIni = $noteIni;

        return $this;
    }

    public function getNoteRat(): ?float
    {
        return $this->noteRat;
    }

    public function setNoteRat(?float $noteRat): self
    {
        $this->noteRat = $noteRat;

        return $this;
    }

    public function getNoteRachat(): ?float
    {
        return $this->noteRachat;
    }

    public function setNoteRachat(?float $noteRachat): self
    {
        $this->noteRachat = $noteRachat;

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

    public function getStatutS2(): ?PeStatut
    {
        return $this->statutS2;
    }

    public function setStatutS2(?PeStatut $statutS2): self
    {
        $this->statutS2 = $statutS2;

        return $this;
    }

    public function getStatutDef(): ?PeStatut
    {
        return $this->statutDef;
    }

    public function setStatutDef(?PeStatut $statutDef): self
    {
        $this->statutDef = $statutDef;

        return $this;
    }

    public function getStatutAff(): ?PeStatut
    {
        return $this->statutAff;
    }

    public function setStatutAff(?PeStatut $statutAff): self
    {
        $this->statutAff = $statutAff;

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
}
