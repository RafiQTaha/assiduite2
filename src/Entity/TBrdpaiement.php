<?php

namespace App\Entity;

use App\Repository\TBrdpaiementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TBrdpaiementRepository::class)]
class TBrdpaiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\ManyToOne(targetEntity: XModalites::class, inversedBy: 'bordereaux')]
    private $modalite;

    #[ORM\Column(type: 'float', nullable: true)]
    private $montant;

    #[ORM\ManyToOne(targetEntity: AcEtablissement::class, inversedBy: 'bordereaux')]
    private $etablissement;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bordereaux')]
    private $UserCreated;

    #[ORM\OneToMany(mappedBy: 'bordereau', targetEntity: TReglement::class)]
    private $reglements;

    #[ORM\Column(type: 'float', nullable: true)]
    private $active = 1;

    #[ORM\ManyToOne(targetEntity: user::class, inversedBy: 'tBrdpaiements')]
    private $userAnnulated;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $annulated;

    public function __construct()
    {
        $this->reglements = new ArrayCollection();
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

    public function getModalite(): ?XModalites
    {
        return $this->modalite;
    }

    public function setModalite(?XModalites $modalite): self
    {
        $this->modalite = $modalite;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(?float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getEtablissement(): ?AcEtablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(?AcEtablissement $etablissement): self
    {
        $this->etablissement = $etablissement;

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
        return $this->UserCreated;
    }

    public function setUserCreated(?User $UserCreated): self
    {
        $this->UserCreated = $UserCreated;

        return $this;
    }

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
            $reglement->setBordereau($this);
        }

        return $this;
    }

    public function removeReglement(TReglement $reglement): self
    {
        if ($this->reglements->removeElement($reglement)) {
            // set the owning side to null (unless already changed)
            if ($reglement->getBordereau() === $this) {
                $reglement->setBordereau(null);
            }
        }

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

    public function getUserAnnulated(): ?user
    {
        return $this->userAnnulated;
    }

    public function setUserAnnulated(?user $userAnnulated): self
    {
        $this->userAnnulated = $userAnnulated;

        return $this;
    }

    public function getAnnulated(): ?\DateTimeInterface
    {
        return $this->annulated;
    }

    public function setAnnulated(?\DateTimeInterface $annulated): self
    {
        $this->annulated = $annulated;

        return $this;
    }
}
