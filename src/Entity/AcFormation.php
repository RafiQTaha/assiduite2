<?php

namespace App\Entity;

use App\Repository\AcFormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcFormationRepository::class)]
class AcFormation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_created;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_updated;

    #[ORM\ManyToOne(targetEntity: AcEtablissement::class, inversedBy: 'acFormations')]
    private $etablissement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $abreviation;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nbr_annee;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $active = 1;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: AcPromotion::class)]
    private $acPromotions;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: AcAnnee::class)]
    private $acAnnees;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: PFrais::class)]
    private $frais;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: PEnsgrille::class)]
    private $ensgrilles;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: PEnseignantExcept::class)]
    private $enseignantexcepts;

    #[ORM\OneToMany(mappedBy: 'formationSouhaitee', targetEntity: TEtudiant::class)]
    private $tEtudiants;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $assiduite;

    public function __construct()
    {
        $this->acPromotions = new ArrayCollection();
        $this->acAnnees = new ArrayCollection();
        $this->frais = new ArrayCollection();
        $this->ensgrilles = new ArrayCollection();
        $this->enseignantexcepts = new ArrayCollection();
        $this->tEtudiants = new ArrayCollection();
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

    public function getEtablissement(): ?AcEtablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(?AcEtablissement $etablissement): self
    {
        $this->etablissement = $etablissement;

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

    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    public function setAbreviation(?string $abreviation): self
    {
        $this->abreviation = $abreviation;

        return $this;
    }

    public function getNbrAnnee(): ?int
    {
        return $this->nbr_annee;
    }

    public function setNbrAnnee(?int $nbr_annee): self
    {
        $this->nbr_annee = $nbr_annee;

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

    /**
     * @return Collection|AcPromotion[]
     */
    public function getAcPromotions(): Collection
    {
        return $this->acPromotions;
    }

    public function addAcPromotion(AcPromotion $acPromotion): self
    {
        if (!$this->acPromotions->contains($acPromotion)) {
            $this->acPromotions[] = $acPromotion;
            $acPromotion->setFormation($this);
        }

        return $this;
    }

    public function removeAcPromotion(AcPromotion $acPromotion): self
    {
        if ($this->acPromotions->removeElement($acPromotion)) {
            // set the owning side to null (unless already changed)
            if ($acPromotion->getFormation() === $this) {
                $acPromotion->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AcAnnee[]
     */
    public function getAcAnnees(): Collection
    {
        return $this->acAnnees;
    }

    public function addAcAnnee(AcAnnee $acAnnee): self
    {
        if (!$this->acAnnees->contains($acAnnee)) {
            $this->acAnnees[] = $acAnnee;
            $acAnnee->setFormation($this);
        }

        return $this;
    }

    public function removeAcAnnee(AcAnnee $acAnnee): self
    {
        if ($this->acAnnees->removeElement($acAnnee)) {
            // set the owning side to null (unless already changed)
            if ($acAnnee->getFormation() === $this) {
                $acAnnee->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PFrais[]
     */
    public function getFrais(): Collection
    {
        return $this->frais;
    }

    public function addFrai(PFrais $frai): self
    {
        if (!$this->frais->contains($frai)) {
            $this->frais[] = $frai;
            $frai->setFormation($this);
        }

        return $this;
    }

    public function removeFrai(PFrais $frai): self
    {
        if ($this->frais->removeElement($frai)) {
            // set the owning side to null (unless already changed)
            if ($frai->getFormation() === $this) {
                $frai->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PEnsgrille>
     */
    public function getEnsgrilles(): Collection
    {
        return $this->ensgrilles;
    }

    public function addEnsgrille(PEnsgrille $ensgrille): self
    {
        if (!$this->ensgrilles->contains($ensgrille)) {
            $this->ensgrilles[] = $ensgrille;
            $ensgrille->setFormation($this);
        }

        return $this;
    }

    public function removeEnsgrille(PEnsgrille $ensgrille): self
    {
        if ($this->ensgrilles->removeElement($ensgrille)) {
            // set the owning side to null (unless already changed)
            if ($ensgrille->getFormation() === $this) {
                $ensgrille->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PEnseignantExcept>
     */
    public function getEnseignantexcepts(): Collection
    {
        return $this->enseignantexcepts;
    }

    public function addEnseignantexcept(PEnseignantExcept $enseignantexcept): self
    {
        if (!$this->enseignantexcepts->contains($enseignantexcept)) {
            $this->enseignantexcepts[] = $enseignantexcept;
            $enseignantexcept->setFormation($this);
        }

        return $this;
    }

    public function removeEnseignantexcept(PEnseignantExcept $enseignantexcept): self
    {
        if ($this->enseignantexcepts->removeElement($enseignantexcept)) {
            // set the owning side to null (unless already changed)
            if ($enseignantexcept->getFormation() === $this) {
                $enseignantexcept->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TEtudiant>
     */
    public function getTEtudiants(): Collection
    {
        return $this->tEtudiants;
    }

    public function addTEtudiant(TEtudiant $tEtudiant): self
    {
        if (!$this->tEtudiants->contains($tEtudiant)) {
            $this->tEtudiants[] = $tEtudiant;
            $tEtudiant->setFormationSouhaitee($this);
        }

        return $this;
    }

    public function removeTEtudiant(TEtudiant $tEtudiant): self
    {
        if ($this->tEtudiants->removeElement($tEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($tEtudiant->getFormationSouhaitee() === $this) {
                $tEtudiant->setFormationSouhaitee(null);
            }
        }

        return $this;
    }

    public function getAssiduite(): ?int
    {
        return $this->assiduite;
    }

    public function setAssiduite(?int $assiduite): self
    {
        $this->assiduite = $assiduite;

        return $this;
    }

}
