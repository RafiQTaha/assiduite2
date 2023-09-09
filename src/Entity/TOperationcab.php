<?php

namespace App\Entity;

use App\Repository\TOperationcabRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TOperationcabRepository::class)]
class TOperationcab
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\ManyToOne(targetEntity: TPreinscription::class, inversedBy: 'operationcabs')]
    private $preinscription;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $categorie;

    #[ORM\ManyToOne(targetEntity: AcAnnee::class, inversedBy: 'operationcabs')]
    private $annee;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $observation;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    // #[ORM\ManyToOne(targetEntity: POrganisme::class, inversedBy: 'operationcabs')]
    // private $organisme;

    #[ORM\OneToMany(mappedBy: 'operation', targetEntity: TReglement::class)]
    private $reglements;

    #[ORM\OneToMany(mappedBy: 'operationcab', targetEntity: TOperationdet::class)]
    private $operationdets;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userCreated;

    #[ORM\Column(type: 'float', nullable: true)]
    private $active;

    #[ORM\Column(type: 'float', nullable: true)]
    private $synFlag = 0;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $dateContable;

    #[ORM\Column(type: 'string', length: 25, nullable: true)]
    private $organisme;

    #[ORM\Column(type: 'float', nullable: true)]
    private $annuler = 0;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $facAnnuler;

    public function __construct()
    {
        $this->reglements = new ArrayCollection();
        $this->operationdets = new ArrayCollection();
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

    public function getPreinscription(): ?TPreinscription
    {
        return $this->preinscription;
    }

    public function setPreinscription(?TPreinscription $preinscription): self
    {
        $this->preinscription = $preinscription;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;

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

    // public function getOrganisme(): ?POrganisme
    // {
    //     return $this->organisme;
    // }

    // public function setOrganisme(?POrganisme $organisme): self
    // {
    //     $this->organisme = $organisme;

    //     return $this;
    // }

    /**
     * @return Collection|TReglement[]
     */
    public function getReglements(): Collection
    {
        return $this->reglements;
    }

    public function addReglement(TReglement $reglement): self
    {
        if (!$this->reglements->contains($reglement)) {
            $this->reglements[] = $reglement;
            $reglement->setOperation($this);
        }

        return $this;
    }

    public function removeReglement(TReglement $reglement): self
    {
        if ($this->reglements->removeElement($reglement)) {
            // set the owning side to null (unless already changed)
            if ($reglement->getOperation() === $this) {
                $reglement->setOperation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TOperationdet[]
     */
    public function getOperationdets(): Collection
    {
        return $this->operationdets;
    }

    public function addOperationdet(TOperationdet $operationdet): self
    {
        if (!$this->operationdets->contains($operationdet)) {
            $this->operationdets[] = $operationdet;
            $operationdet->setOperationcab($this);
        }

        return $this;
    }

    public function removeOperationdet(TOperationdet $operationdet): self
    {
        if ($this->operationdets->removeElement($operationdet)) {
            // set the owning side to null (unless already changed)
            if ($operationdet->getOperationcab() === $this) {
                $operationdet->setOperationcab(null);
            }
        }

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

    public function getActive(): ?float
    {
        return $this->active;
    }

    public function setActive(?float $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getSynFlag(): ?float
    {
        return $this->synFlag;
    }

    public function setSynFlag(?float $synFlag): self
    {
        $this->synFlag = $synFlag;

        return $this;
    }

    public function getDateContable(): ?int
    {
        return $this->dateContable;
    }

    public function setDateContable(?int $dateContable): self
    {
        $this->dateContable = $dateContable;

        return $this;
    }

    public function getOrganisme(): ?string
    {
        return $this->organisme;
    }

    public function setOrganisme(?string $organisme): self
    {
        $this->organisme = $organisme;

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

    public function getFacAnnuler(): ?int
    {
        return $this->facAnnuler;
    }

    public function setFacAnnuler(?int $facAnnuler): self
    {
        $this->facAnnuler = $facAnnuler;

        return $this;
    }
}
