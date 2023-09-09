<?php

namespace App\Entity;

use App\Repository\ExEnotesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExEnotesRepository::class)]
class ExEnotes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: TInscription::class, inversedBy: 'enotes')]
    private $inscription;

    #[ORM\ManyToOne(targetEntity: AcElement::class, inversedBy: 'enotes')]
    private $element;

    #[ORM\Column(type: 'float', nullable: true)]
    private $mcc;

    #[ORM\Column(type: 'float', nullable: true)]
    private $mtp;

    #[ORM\Column(type: 'float', nullable: true)]
    private $mef;

    #[ORM\Column(type: 'float', nullable: true)]
    private $ccr;

    #[ORM\Column(type: 'float', nullable: true)]
    private $tpr;

    #[ORM\Column(type: 'float', nullable: true)]
    private $efr;

    #[ORM\Column(type: 'float', nullable: true)]
    private $noteIni;

    #[ORM\Column(type: 'float', nullable: true)]
    private $note;

    #[ORM\Column(type: 'float', nullable: true)]
    private $noteRat;

    #[ORM\Column(type: 'float', nullable: true)]
    private $noteRachat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $observation;

    #[ORM\Column(type: 'float', nullable: true)]
    private $ccRachat;

    #[ORM\Column(type: 'float', nullable: true)]
    private $tp_Rachat;

    #[ORM\Column(type: 'float', nullable: true)]
    private $efRachat;

    #[ORM\ManyToOne(targetEntity: PeStatut::class)]
    private $statutS1;

    #[ORM\ManyToOne(targetEntity: PeStatut::class)]
    private $statutS2;

    #[ORM\ManyToOne(targetEntity: PeStatut::class)]
    private $statutDef;

    #[ORM\ManyToOne(targetEntity: PeStatut::class)]
    private $statutAff;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userCreated;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $pondMef = 1;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $pondEfr = 1;

    #[ORM\ManyToOne(targetEntity: PeStatut::class)]
    private $statutRachat;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $statutAffichage;

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

    public function getElement(): ?AcElement
    {
        return $this->element;
    }

    public function setElement(?AcElement $element): self
    {
        $this->element = $element;

        return $this;
    }

    public function getMcc(): ?float
    {
        return $this->mcc;
    }

    public function setMcc(?float $mcc): self
    {
        $this->mcc = $mcc;

        return $this;
    }

    public function getMtp(): ?float
    {
        return $this->mtp;
    }

    public function setMtp(?float $mtp): self
    {
        $this->mtp = $mtp;

        return $this;
    }

    public function getMef(): ?float
    {
        return $this->mef;
    }

    public function setMef(?float $mef): self
    {
        $this->mef = $mef;

        return $this;
    }

    public function getCcr(): ?float
    {
        return $this->ccr;
    }

    public function setCcr(?float $ccr): self
    {
        $this->ccr = $ccr;

        return $this;
    }

    public function getTpr(): ?float
    {
        return $this->tpr;
    }

    public function setTpr(?float $tpr): self
    {
        $this->tpr = $tpr;

        return $this;
    }

    public function getEfr(): ?float
    {
        return $this->efr;
    }

    public function setEfr(?float $efr): self
    {
        $this->efr = $efr;

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

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): self
    {
        $this->note = $note;

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

    public function getCcRachat(): ?float
    {
        return $this->ccRachat;
    }

    public function setCcRachat(?float $ccRachat): self
    {
        $this->ccRachat = $ccRachat;

        return $this;
    }

    public function getTpRachat(): ?float
    {
        return $this->tp_Rachat;
    }

    public function setTpRachat(?float $tp_Rachat): self
    {
        $this->tp_Rachat = $tp_Rachat;

        return $this;
    }

    public function getEfRachat(): ?float
    {
        return $this->efRachat;
    }

    public function setEfRachat(?float $efRachat): self
    {
        $this->efRachat = $efRachat;

        return $this;
    }

    public function getStatutS1(): ?PeStatut
    {
        return $this->statutS1;
    }

    public function setStatutS1(?PeStatut $statutS1): self
    {
        $this->statutS1 = $statutS1;

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

    public function getPondMef(): ?int
    {
        return $this->pondMef;
    }

    public function setPondMef(?int $pondMef): self
    {
        $this->pondMef = $pondMef;

        return $this;
    }

    public function getPondEfr(): ?int
    {
        return $this->pondEfr;
    }

    public function setPondEfr(?int $pondEfr): self
    {
        $this->pondEfr = $pondEfr;

        return $this;
    }

    public function getStatutRachat(): ?PeStatut
    {
        return $this->statutRachat;
    }

    public function setStatutRachat(?PeStatut $statutRachat): self
    {
        $this->statutRachat = $statutRachat;

        return $this;
    }

    public function getStatutAffichage(): ?int
    {
        return $this->statutAffichage;
    }

    public function setStatutAffichage(?int $statutAffichage): self
    {
        $this->statutAffichage = $statutAffichage;

        return $this;
    }
}
