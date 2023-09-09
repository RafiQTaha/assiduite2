<?php

namespace App\Entity;

use App\Repository\DPrediplomesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DPrediplomesRepository::class)]
class DPrediplomes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $code;

    #[ORM\ManyToOne(targetEntity: ExFnotes::class, inversedBy: 'dPrediplomes')]
    private $fnote;

    #[ORM\ManyToOne(targetEntity: PDiplomes::class, inversedBy: 'dPrediplomes')]
    private $diplome;

    #[ORM\Column(type: 'float', nullable: true)]
    private $note;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $mention;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $observation;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userCreated;

    #[ORM\ManyToOne(targetEntity: AcAnnee::class)]
    private $annee;

    #[ORM\OneToMany(mappedBy: 'prediplome', targetEntity: DDiplomes::class)]
    private $dDiplomes;

    public function __construct()
    {
        $this->dDiplomes = new ArrayCollection();
    }

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

    public function getFnote(): ?ExFnotes
    {
        return $this->fnote;
    }

    public function setFnote(?ExFnotes $fnote): self
    {
        $this->fnote = $fnote;

        return $this;
    }

    public function getDiplome(): ?PDiplomes
    {
        return $this->diplome;
    }

    public function setDiplome(?PDiplomes $diplome): self
    {
        $this->diplome = $diplome;

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

    public function getMention(): ?string
    {
        return $this->mention;
    }

    public function setMention(?string $mention): self
    {
        $this->mention = $mention;

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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

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

    public function getAnnee(): ?AcAnnee
    {
        return $this->annee;
    }

    public function setAnnee(?AcAnnee $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @return Collection<int, DDiplomes>
     */
    public function getDDiplomes(): Collection
    {
        return $this->dDiplomes;
    }

    public function addDDiplome(DDiplomes $dDiplome): self
    {
        if (!$this->dDiplomes->contains($dDiplome)) {
            $this->dDiplomes[] = $dDiplome;
            $dDiplome->setPrediplome($this);
        }

        return $this;
    }

    public function removeDDiplome(DDiplomes $dDiplome): self
    {
        if ($this->dDiplomes->removeElement($dDiplome)) {
            // set the owning side to null (unless already changed)
            if ($dDiplome->getPrediplome() === $this) {
                $dDiplome->setPrediplome(null);
            }
        }

        return $this;
    }
}
