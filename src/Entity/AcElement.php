<?php

namespace App\Entity;

use App\Repository\AcElementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcElementRepository::class)]
class AcElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_created;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_updated;

    #[ORM\ManyToOne(targetEntity: AcModule::class, inversedBy: 'acElements')]
    private $module;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $active;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $couleur;

    #[ORM\Column(type: 'float', nullable: true)]
    private $coefficient;

    #[ORM\Column(type: 'json', nullable: true)]
    private $coefficient_epreuve;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $type;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $cours_document;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\OneToMany(mappedBy: 'element', targetEntity: AcEpreuve::class)]
    private $epreuves;

    #[ORM\OneToMany(mappedBy: 'element', targetEntity: ExControle::class)]
    private $controles;

    #[ORM\OneToMany(mappedBy: 'element', targetEntity: ExEnotes::class)]
    private $enotes;

    #[ORM\OneToMany(mappedBy: 'element', targetEntity: PrProgrammation::class)]
    private $programmations;

    #[ORM\ManyToOne(targetEntity: TypeElement::class, inversedBy: 'elements')]
    private $nature;

    // #[ORM\ManyToOne(targetEntity: TypeElement::class, inversedBy: 'acElements')]
    // private $nature;

    public function __construct()
    {
        $this->epreuves = new ArrayCollection();
        $this->controles = new ArrayCollection();
        $this->enotes = new ArrayCollection();
        $this->programmations = new ArrayCollection();
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

    public function getModule(): ?AcModule
    {
        return $this->module;
    }

    public function setModule(?AcModule $module): self
    {
        $this->module = $module;

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

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

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

    public function getCoefficientEpreuve(): ?array
    {
        return $this->coefficient_epreuve;
    }

    public function setCoefficientEpreuve(?array $coefficient_epreuve): self
    {
        $this->coefficient_epreuve = $coefficient_epreuve;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCoursDocument(): ?int
    {
        return $this->cours_document;
    }

    public function setCoursDocument(?int $cours_document): self
    {
        $this->cours_document = $cours_document;

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
     * @return Collection|AcEpreuve[]
     */
    public function getEpreuves(): Collection
    {
        return $this->epreuves;
    }

    public function addEpreufe(AcEpreuve $epreufe): self
    {
        if (!$this->epreuves->contains($epreufe)) {
            $this->epreuves[] = $epreufe;
            $epreufe->setElement($this);
        }

        return $this;
    }

    public function removeEpreufe(AcEpreuve $epreufe): self
    {
        if ($this->epreuves->removeElement($epreufe)) {
            // set the owning side to null (unless already changed)
            if ($epreufe->getElement() === $this) {
                $epreufe->setElement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ExControle[]
     */
    public function getControles(): Collection
    {
        return $this->controles;
    }

    public function addControle(ExControle $controle): self
    {
        if (!$this->controles->contains($controle)) {
            $this->controles[] = $controle;
            $controle->setElement($this);
        }

        return $this;
    }

    public function removeControle(ExControle $controle): self
    {
        if ($this->controles->removeElement($controle)) {
            // set the owning side to null (unless already changed)
            if ($controle->getElement() === $this) {
                $controle->setElement(null);
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
            $enote->setElement($this);
        }

        return $this;
    }

    public function removeEnote(ExEnotes $enote): self
    {
        if ($this->enotes->removeElement($enote)) {
            // set the owning side to null (unless already changed)
            if ($enote->getElement() === $this) {
                $enote->setElement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PrProgrammation[]
     */
    public function getProgrammations(): Collection
    {
        return $this->programmations;
    }

    public function addProgrammation(PrProgrammation $programmation): self
    {
        if (!$this->programmations->contains($programmation)) {
            $this->programmations[] = $programmation;
            $programmation->setElement($this);
        }

        return $this;
    }

    public function removeProgrammation(PrProgrammation $programmation): self
    {
        if ($this->programmations->removeElement($programmation)) {
            // set the owning side to null (unless already changed)
            if ($programmation->getElement() === $this) {
                $programmation->setElement(null);
            }
        }

        return $this;
    }

    public function getNature(): ?TypeElement
    {
        return $this->nature;
    }

    public function setNature(?TypeElement $nature): self
    {
        $this->nature = $nature;

        return $this;
    }
}
