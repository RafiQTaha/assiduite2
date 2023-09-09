<?php

namespace App\Entity;

use App\Repository\PDocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PDocumentRepository::class)]
class PDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\ManyToOne(targetEntity: AcEtablissement::class, inversedBy: 'documents')]
    private $etablissement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $attribution;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $active;

    #[ORM\ManyToOne(targetEntity: NatureDemande::class, inversedBy: 'documents')]
    private $natureDemande;

    #[ORM\OneToMany(mappedBy: 'document', targetEntity: TAdmissionDocument::class)]
    private $admissionDocuments;

    #[ORM\ManyToMany(targetEntity: TPreinscription::class, mappedBy: 'documents')]
    private $preinscriptions;

    public function __construct()
    {
        $this->admissionDocuments = new ArrayCollection();
        $this->preinscriptions = new ArrayCollection();
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

    public function getEtablissement(): ?AcEtablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(?AcEtablissement $etablissement): self
    {
        $this->etablissement = $etablissement;

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

    public function getAttribution(): ?string
    {
        return $this->attribution;
    }

    public function setAttribution(?string $attribution): self
    {
        $this->attribution = $attribution;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getNatureDemande(): ?NatureDemande
    {
        return $this->natureDemande;
    }

    public function setNatureDemande(?NatureDemande $natureDemande): self
    {
        $this->natureDemande = $natureDemande;

        return $this;
    }

    /**
     * @return Collection|TAdmissionDocument[]
     */
    public function getAdmissionDocuments(): Collection
    {
        return $this->admissionDocuments;
    }

    public function addAdmissionDocument(TAdmissionDocument $admissionDocument): self
    {
        if (!$this->admissionDocuments->contains($admissionDocument)) {
            $this->admissionDocuments[] = $admissionDocument;
            $admissionDocument->setDocument($this);
        }

        return $this;
    }

    public function removeAdmissionDocument(TAdmissionDocument $admissionDocument): self
    {
        if ($this->admissionDocuments->removeElement($admissionDocument)) {
            // set the owning side to null (unless already changed)
            if ($admissionDocument->getDocument() === $this) {
                $admissionDocument->setDocument(null);
            }
        }

        return $this;
    }
    

    /**
     * @return Collection|TPreinscription[]
     */
    public function getPreinscriptions(): Collection
    {
        return $this->preinscriptions;
    }

    public function addPreinscription(TPreinscription $preinscription): self
    {
        if (!$this->preinscriptions->contains($preinscription)) {
            $this->preinscriptions[] = $preinscription;
            $preinscription->addDocument($this);
        }

        return $this;
    }

    public function removePreinscription(TPreinscription $preinscription): self
    {
        if ($this->preinscriptions->removeElement($preinscription)) {
            $preinscription->removeDocument($this);
        }

        return $this;
    }
}
