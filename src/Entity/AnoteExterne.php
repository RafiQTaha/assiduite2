<?php

namespace App\Entity;

use App\Repository\AnoteExterneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnoteExterneRepository::class)]
class AnoteExterne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: TAdmission::class, inversedBy: 'anoteExternes')]
    private $admission;

    #[ORM\ManyToOne(targetEntity: AcAnnee::class, inversedBy: 'anoteExternes')]
    private $annee;

    #[ORM\Column(type: 'float', nullable: true)]
    private $note;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_created;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user_updated;

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

    public function getAnnee(): ?AcAnnee
    {
        return $this->annee;
    }

    public function setAnnee(?AcAnnee $annee): self
    {
        $this->annee = $annee;

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
}
