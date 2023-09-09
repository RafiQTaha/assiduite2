<?php

namespace App\Entity;

use App\Repository\ExGnotesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExGnotesRepository::class)]
class ExGnotes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: AcEpreuve::class, inversedBy: 'gnotes')]
    private $epreuve;

    #[ORM\ManyToOne(targetEntity: TInscription::class, inversedBy: 'gnotes')]
    private $inscription;

    #[ORM\Column(type: 'float', nullable: true)]
    private $note;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $anonymat;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $absence;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $observation;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userCreated;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userUpdated;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $statutAffichage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEpreuve(): ?AcEpreuve
    {
        return $this->epreuve;
    }

    public function setEpreuve(?AcEpreuve $epreuve): self
    {
        $this->epreuve = $epreuve;

        return $this;
    }   

    public function getInscription(): ?TInscription
    {
        return $this->inscription;
    }

    public function setInscription(?TInscription $inscription): self
    {
        $this->inscription = $inscription;

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

    public function getAnonymat(): ?int
    {
        return $this->anonymat;
    }

    public function setAnonymat(?int $anonymat): self
    {
        $this->anonymat = $anonymat;

        return $this;
    }

    public function getAbsence(): ?bool
    {
        return $this->absence;
    }

    public function setAbsence(?bool $absence): self
    {
        $this->absence = $absence;

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

    public function getUserCreated(): ?User
    {
        return $this->userCreated;
    }

    public function setUserCreated(?User $userCreated): self
    {
        $this->userCreated = $userCreated;

        return $this;
    }

    public function getUserUpdated(): ?User
    {
        return $this->userUpdated;
    }

    public function setUserUpdated(?User $userUpdated): self
    {
        $this->userUpdated = $userUpdated;

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

    public function getStatutAffichage(): ?int
    {
        return $this->statutAffichage;
    }

    public function setStatutAffichage(?int $statutAffichage): self
    {
        $this->statutAffichage = $statutAffichage;

        return $this;
    }
}
