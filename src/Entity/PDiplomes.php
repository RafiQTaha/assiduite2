<?php

namespace App\Entity;

use App\Repository\PDiplomesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PDiplomesRepository::class)]
class PDiplomes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $code;

    #[ORM\ManyToOne(targetEntity: AcFormation::class)]
    private $formation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'string', length: 25, nullable: true)]
    private $abreviation;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userCreated;

    #[ORM\OneToMany(mappedBy: 'diplome', targetEntity: DPrediplomes::class)]
    private $dPrediplomes;

    public function __construct()
    {
        $this->dPrediplomes = new ArrayCollection();
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

    public function getFormation(): ?AcFormation
    {
        return $this->formation;
    }

    public function setFormation(?AcFormation $formation): self
    {
        $this->formation = $formation;

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

    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    public function setAbreviation(?string $abreviation): self
    {
        $this->abreviation = $abreviation;

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
            $dPrediplome->setDiplome($this);
        }

        return $this;
    }

    public function removeDPrediplome(DPrediplomes $dPrediplome): self
    {
        if ($this->dPrediplomes->removeElement($dPrediplome)) {
            // set the owning side to null (unless already changed)
            if ($dPrediplome->getDiplome() === $this) {
                $dPrediplome->setDiplome(null);
            }
        }

        return $this;
    }
}
