<?php

namespace App\Entity;

use App\Repository\AcPromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcPromotionRepository::class)]
class AcPromotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: AcFormation::class, inversedBy: 'acPromotions')]
    private $formation;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_created;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_updated;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $ordre;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $active = 1;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $updated;

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: AcSemestre::class)]
    private $semestres;

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: TInscription::class)]
    private $inscriptions;

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: HAlbhon::class)]
    private $albhonss;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $limite;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designationEn;

    public function __construct()
    {
        $this->semestres = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
        $this->albhonss = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserCreated(): ?User
    {
        return $this->user_created;
    }

    public function setUserCreated(?User $user_created): self
    {
        $this->user_created = $user_created;

        return $this;
    }

    public function getUserUpdated(): ?User
    {
        return $this->user_updated;
    }

    public function setUserUpdated(?User $user_updated): self
    {
        $this->user_updated = $user_updated;

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

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(?int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(?int $active): self
    {
        $this->active = $active;

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

    public function getUpdated(): ?int
    {
        return $this->updated;
    }

    public function setUpdated(?int $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return Collection|AcSemestre[]
     */
    public function getSemestres(): Collection
    {
        return $this->semestres;
    }

    public function addSemestre(AcSemestre $semestre): self
    {
        if (!$this->semestres->contains($semestre)) {
            $this->semestres[] = $semestre;
            $semestre->setPromotion($this);
        }

        return $this;
    }

    public function removeSemestre(AcSemestre $semestre): self
    {
        if ($this->semestres->removeElement($semestre)) {
            // set the owning side to null (unless already changed)
            if ($semestre->getPromotion() === $this) {
                $semestre->setPromotion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TInscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(TInscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setPromotion($this);
        }

        return $this;
    }

    public function removeInscription(TInscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getPromotion() === $this) {
                $inscription->setPromotion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HAlbhon>
     */
    public function getAlbhonss(): Collection
    {
        return $this->albhonss;
    }

    public function addAlbhonss(HAlbhon $albhonss): self
    {
        if (!$this->albhonss->contains($albhonss)) {
            $this->albhonss[] = $albhonss;
            $albhonss->setPromotion($this);
        }

        return $this;
    }

    public function removeAlbhonss(HAlbhon $albhonss): self
    {
        if ($this->albhonss->removeElement($albhonss)) {
            // set the owning side to null (unless already changed)
            if ($albhonss->getPromotion() === $this) {
                $albhonss->setPromotion(null);
            }
        }

        return $this;
    }

    public function getLimite(): ?int
    {
        return $this->limite;
    }

    public function setLimite(int $limite): self
    {
        $this->limite = $limite;

        return $this;
    }

    public function getDesignationEn(): ?string
    {
        return $this->designationEn;
    }

    public function setDesignationEn(?string $designationEn): self
    {
        $this->designationEn = $designationEn;

        return $this;
    }
}
