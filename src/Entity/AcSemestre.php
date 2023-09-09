<?php

namespace App\Entity;

use App\Repository\AcSemestreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcSemestreRepository::class)]
class AcSemestre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_created;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_updated;

    #[ORM\ManyToOne(targetEntity: AcPromotion::class, inversedBy: 'semestres')]
    private $promotion;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $active = 1;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\Column(type: 'float', nullable: true)]
    private $coefficient;

    #[ORM\Column(type: 'float', nullable: true)]
    private $coefficient_ass;

    #[ORM\OneToMany(mappedBy: 'semestre', targetEntity: AcModule::class)]
    private $modules;

    #[ORM\OneToMany(mappedBy: 'semestre', targetEntity: Pv::class)]
    private $pvs;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
        $this->pvs = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
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

    public function getPromotion(): ?AcPromotion
    {
        return $this->promotion;
    }

    public function setPromotion(?AcPromotion $promotion): self
    {
        $this->promotion = $promotion;

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

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getCoefficient(): ?float
    {
        return $this->coefficient;
    }

    public function setCoefficient(?float $coefficient): self
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    public function getCoefficientAss(): ?float
    {
        return $this->coefficient_ass;
    }

    public function setCoefficientAss(?float $coefficient_ass): self
    {
        $this->coefficient_ass = $coefficient_ass;

        return $this;
    }

    /**
     * @return Collection|AcModule[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(AcModule $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->setSemestre($this);
        }

        return $this;
    }

    public function removeModule(AcModule $module): self
    {
        if ($this->modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getSemestre() === $this) {
                $module->setSemestre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pv>
     */
    public function getPvs(): Collection
    {
        return $this->pvs;
    }

    public function addPv(Pv $pv): self
    {
        if (!$this->pvs->contains($pv)) {
            $this->pvs[] = $pv;
            $pv->setSemestre($this);
        }

        return $this;
    }

    public function removePv(Pv $pv): self
    {
        if ($this->pvs->removeElement($pv)) {
            // set the owning side to null (unless already changed)
            if ($pv->getSemestre() === $this) {
                $pv->setSemestre(null);
            }
        }

        return $this;
    }
}
