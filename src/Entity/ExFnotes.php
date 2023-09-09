<?php

namespace App\Entity;

use App\Repository\ExFnotesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExFnotesRepository::class)]
class ExFnotes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: TAdmission::class)]
    private $admission;

    #[ORM\ManyToOne(targetEntity: AcFormation::class)]
    private $formation;

    #[ORM\Column(type: 'float', nullable: true)]
    private $note;

    #[ORM\Column(type: 'float', nullable: true)]
    private $noteSec;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $observation;

    #[ORM\Column(type: 'float', nullable: true)]
    private $flag;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userCreated;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\OneToMany(mappedBy: 'fnote', targetEntity: DPrediplomes::class)]
    private $dPrediplomes;

    public function __construct()
    {
        $this->dPrediplomes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFormation(): ?AcFormation
    {
        return $this->formation;
    }

    public function setFormation(?AcFormation $formation): self
    {
        $this->formation = $formation;

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

    public function getNoteSec(): ?float
    {
        return $this->noteSec;
    }

    public function setNoteSec(float $noteSec): self
    {
        $this->noteSec = $noteSec;

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

    public function getFlag(): ?float
    {
        return $this->flag;
    }

    public function setFlag(?float $flag): self
    {
        $this->flag = $flag;

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

    /**
     * @return Collection<int, DPrediplomes>
     */
    public function getDPrediplomes(): Collection
    {
        return $this->dPrediplomes;
    }

    public function addDPrediplome(DPrediplomes $dPrediplome): self
    {
        if (!$this->dPrediplomes->contains($dPrediplome)) {
            $this->dPrediplomes[] = $dPrediplome;
            $dPrediplome->setFnote($this);
        }

        return $this;
    }

    public function removeDPrediplome(DPrediplomes $dPrediplome): self
    {
        if ($this->dPrediplomes->removeElement($dPrediplome)) {
            // set the owning side to null (unless already changed)
            if ($dPrediplome->getFnote() === $this) {
                $dPrediplome->setFnote(null);
            }
        }

        return $this;
    }
}
