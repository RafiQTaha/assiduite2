<?php

namespace App\Entity;

use App\Repository\TInscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TInscriptionRepository::class)]
class TInscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PStatut::class, inversedBy: 'inscriptions')]
    private $statut;

    #[ORM\ManyToOne(targetEntity: TAdmission::class, inversedBy: 'inscriptions')]
    private $admission;

    #[ORM\ManyToOne(targetEntity: AcAnnee::class, inversedBy: 'inscriptions')]
    private $annee;

    #[ORM\ManyToOne(targetEntity: AcPromotion::class, inversedBy: 'inscriptions')]
    private $promotion;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userCreated;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userUpdated;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $codeAnonymat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $codeAnonymatRat;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $reserve;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $motif;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $emplacement;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $typeCand;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: ExGnotes::class)]
    private $gnotes;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: ExEnotes::class)]
    private $enotes;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: ExMnotes::class)]
    private $mnotes;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: ExSnotes::class)]
    private $snotes;

    #[ORM\OneToOne(mappedBy: 'inscription', targetEntity: ExAnotes::class, cascade: ['persist', 'remove'])]
    private $anotes;

    #[ORM\ManyToOne(targetEntity: PGroupe::class, inversedBy: 'inscriptions')]
    private $groupe;

    #[ORM\Column(type: 'string', nullable: true)]
    private $salle;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: TInscriptionImpLog::class)]
    private $tInscriptionImpLogs;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: TInscriptionImpControle::class)]
    private $tInscriptionImpControles;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: InsSanctionner::class)]
    private $insSanctionners;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $statutUpdated;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userStatutUpdated;

    public function __construct()
    {
        $this->gnotes = new ArrayCollection();
        $this->enotes = new ArrayCollection();
        $this->mnotes = new ArrayCollection();
        $this->snotes = new ArrayCollection();
        $this->tInscriptionImpLogs = new ArrayCollection();
        $this->tInscriptionImpControles = new ArrayCollection();
        $this->insSanctionners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?PStatut
    {
        return $this->statut;
    }

    public function setStatut(?PStatut $statut): self
    {
        $this->statut = $statut;

        return $this;
    }


    public function getAdmission(): ?TAdmission
    {
        return $this->admission;
    }

    public function setAdmission(?TAdmission $admission): self
    {
        $this->admission = $admission;

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

    public function getPromotion(): ?AcPromotion
    {
        return $this->promotion;
    }

    public function setPromotion(?AcPromotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getUserCreated(): ?user
    {
        return $this->userCreated;
    }

    public function setUserCreated(?user $userCreated): self
    {
        $this->userCreated = $userCreated;

        return $this;
    }

    public function getUserUpdated(): ?user
    {
        return $this->userUpdated;
    }

    public function setUserUpdated(?user $userUpdated): self
    {
        $this->userUpdated = $userUpdated;

        return $this;
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

    public function getCodeAnonymat(): ?string
    {
        return $this->codeAnonymat;
    }

    public function setCodeAnonymat(?string $codeAnonymat): self
    {
        $this->codeAnonymat = $codeAnonymat;

        return $this;
    }

    public function getCodeAnonymatRat(): ?string
    {
        return $this->codeAnonymatRat;
    }

    public function setCodeAnonymatRat(?string $codeAnonymatRat): self
    {
        $this->codeAnonymatRat = $codeAnonymatRat;

        return $this;
    }

    public function getReserve(): ?int
    {
        return $this->reserve;
    }

    public function setReserve(?int $reserve): self
    {
        $this->reserve = $reserve;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getEmplacement(): ?int
    {
        return $this->emplacement;
    }

    public function setEmplacement(int $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getTypeCand(): ?string
    {
        return $this->typeCand;
    }

    public function setTypeCand(?string $typeCand): self
    {
        $this->typeCand = $typeCand;

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

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return Collection|ExGnotes[]
     */
    public function getGnotes(): Collection
    {
        return $this->gnotes;
    }

    public function addGnote(ExGnotes $gnote): self
    {
        if (!$this->gnotes->contains($gnote)) {
            $this->gnotes[] = $gnote;
            $gnote->setInscription($this);
        }

        return $this;
    }

    public function removeGnote(ExGnotes $gnote): self
    {
        if ($this->gnotes->removeElement($gnote)) {
            // set the owning side to null (unless already changed)
            if ($gnote->getInscription() === $this) {
                $gnote->setInscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExEnotes[]
     */
    public function getEnotes(): Collection
    {
        return $this->enotes;
    }

    public function addEnote(ExEnotes $enote): self
    {
        if (!$this->enotes->contains($enote)) {
            $this->enotes[] = $enote;
            $enote->setInscription($this);
        }

        return $this;
    }

    public function removeEnote(ExEnotes $enote): self
    {
        if ($this->enotes->removeElement($enote)) {
            // set the owning side to null (unless already changed)
            if ($enote->getInscription() === $this) {
                $enote->setInscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExMnotes[]
     */
    public function getMnotes(): Collection
    {
        return $this->mnotes;
    }

    public function addMnote(ExMnotes $mnote): self
    {
        if (!$this->mnotes->contains($mnote)) {
            $this->mnotes[] = $mnote;
            $mnote->setInscription($this);
        }

        return $this;
    }

    public function removeMnote(ExMnotes $mnote): self
    {
        if ($this->mnotes->removeElement($mnote)) {
            // set the owning side to null (unless already changed)
            if ($mnote->getInscription() === $this) {
                $mnote->setInscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExSnotes[]
     */
    public function getSnotes(): Collection
    {
        return $this->snotes;
    }

    public function addSnote(ExSnotes $snote): self
    {
        if (!$this->snotes->contains($snote)) {
            $this->snotes[] = $snote;
            $snote->setInscription($this);
        }

        return $this;
    }

    public function removeSnote(ExSnotes $snote): self
    {
        if ($this->snotes->removeElement($snote)) {
            // set the owning side to null (unless already changed)
            if ($snote->getInscription() === $this) {
                $snote->setInscription(null);
            }
        }

        return $this;
    }

    public function getAnotes(): ?ExAnotes
    {
        return $this->anotes;
    }

    public function setAnotes(?ExAnotes $anotes): self
    {
        // unset the owning side of the relation if necessary
        if ($anotes === null && $this->anotes !== null) {
            $this->anotes->setInscription(null);
        }

        // set the owning side of the relation if necessary
        if ($anotes !== null && $anotes->getInscription() !== $this) {
            $anotes->setInscription($this);
        }

        $this->anotes = $anotes;

        return $this;
    }

    public function getGroupe(): ?PGroupe
    {
        return $this->groupe;
    }

    public function setGroupe(?PGroupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->salle;
    }

    public function setSalle(?string $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * @return Collection<int, TInscriptionImpLog>
     */
    public function getTInscriptionImpLogs(): Collection
    {
        return $this->tInscriptionImpLogs;
    }

    public function addTInscriptionImpLog(TInscriptionImpLog $tInscriptionImpLog): self
    {
        if (!$this->tInscriptionImpLogs->contains($tInscriptionImpLog)) {
            $this->tInscriptionImpLogs[] = $tInscriptionImpLog;
            $tInscriptionImpLog->setInscription($this);
        }

        return $this;
    }

    public function removeTInscriptionImpLog(TInscriptionImpLog $tInscriptionImpLog): self
    {
        if ($this->tInscriptionImpLogs->removeElement($tInscriptionImpLog)) {
            // set the owning side to null (unless already changed)
            if ($tInscriptionImpLog->getInscription() === $this) {
                $tInscriptionImpLog->setInscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TInscriptionImpControle>
     */
    public function getTInscriptionImpControles(): Collection
    {
        return $this->tInscriptionImpControles;
    }

    public function addTInscriptionImpControle(TInscriptionImpControle $tInscriptionImpControle): self
    {
        if (!$this->tInscriptionImpControles->contains($tInscriptionImpControle)) {
            $this->tInscriptionImpControles[] = $tInscriptionImpControle;
            $tInscriptionImpControle->setInscription($this);
        }

        return $this;
    }

    public function removeTInscriptionImpControle(TInscriptionImpControle $tInscriptionImpControle): self
    {
        if ($this->tInscriptionImpControles->removeElement($tInscriptionImpControle)) {
            // set the owning side to null (unless already changed)
            if ($tInscriptionImpControle->getInscription() === $this) {
                $tInscriptionImpControle->setInscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InsSanctionner>
     */
    public function getInsSanctionners(): Collection
    {
        return $this->insSanctionners;
    }

    public function addInsSanctionner(InsSanctionner $insSanctionner): self
    {
        if (!$this->insSanctionners->contains($insSanctionner)) {
            $this->insSanctionners[] = $insSanctionner;
            $insSanctionner->setInscription($this);
        }

        return $this;
    }

    public function removeInsSanctionner(InsSanctionner $insSanctionner): self
    {
        if ($this->insSanctionners->removeElement($insSanctionner)) {
            // set the owning side to null (unless already changed)
            if ($insSanctionner->getInscription() === $this) {
                $insSanctionner->setInscription(null);
            }
        }

        return $this;
    }

    public function getUserStatutUpdated(): ?user
    {
        return $this->userStatutUpdated;
    }

    public function setUserStatutUpdated(?user $userStatutUpdated): self
    {
        $this->userStatutUpdated = $userStatutUpdated;

        return $this;
    }

    public function getStatutUpdated(): ?\DateTimeInterface
    {
        return $this->statutUpdated;
    }

    public function setStatutUpdated(?\DateTimeInterface $statutUpdated): self
    {
        $this->statutUpdated = $statutUpdated;

        return $this;
    }

}
