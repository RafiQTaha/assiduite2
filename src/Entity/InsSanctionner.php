<?php

namespace App\Entity;

use App\Repository\InsSanctionnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InsSanctionnerRepository::class)]
class InsSanctionner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: TInscription::class, inversedBy: 'insSanctionners')]
    private $inscription;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateIncident;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateReunion;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateDecision;

    #[ORM\Column(type: 'float', nullable: true)]
    private $active;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'insSanctionners')]
    private $userCreated;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'insSanctionners')]
    private $userUpdated;

    #[ORM\ManyToOne(targetEntity: SousAgression::class, inversedBy: 'insSanctionners')]
    private $agression;

    #[ORM\Column(type: 'float', nullable: true)]
    private $valide;

    #[ORM\Column(type: 'array', nullable: true)]
    private $autreSanction = [];

    #[ORM\ManyToMany(targetEntity: Sanction::class, inversedBy: 'insSanctionners')]
    private $sanction;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $autreAgression;

    #[ORM\Column(type: 'float', nullable: true)]
    private $sansSuite;

    public function __construct()
    {
        $this->sanction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateIncident(): ?\DateTimeInterface
    {
        return $this->dateIncident;
    }

    public function setDateIncident(?\DateTimeInterface $dateIncident): self
    {
        $this->dateIncident = $dateIncident;

        return $this;
    }

    public function getDateReunion(): ?\DateTimeInterface
    {
        return $this->dateReunion;
    }

    public function setDateReunion(?\DateTimeInterface $dateReunion): self
    {
        $this->dateReunion = $dateReunion;

        return $this;
    }

    public function getDateDecision(): ?\DateTimeInterface
    {
        return $this->dateDecision;
    }

    public function setDateDecision(?\DateTimeInterface $dateDecision): self
    {
        $this->dateDecision = $dateDecision;

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

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

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

    public function getAgression(): ?sousAgression
    {
        return $this->agression;
    }

    public function setAgression(?sousAgression $agression): self
    {
        $this->agression = $agression;

        return $this;
    }

    public function getValide(): ?float
    {
        return $this->valide;
    }

    public function setValide(?float $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getAutreSanction(): ?array
    {
        return $this->autreSanction;
    }

    public function setAutreSanction(?array $autreSanction): self
    {
        $this->autreSanction = $autreSanction;

        return $this;
    }

    /**
     * @return Collection<int, Sanction>
     */
    public function getSanction(): Collection
    {
        return $this->sanction;
    }

    public function addSanction(Sanction $sanction): self
    {
        if (!$this->sanction->contains($sanction)) {
            $this->sanction[] = $sanction;
        }

        return $this;
    }

    public function removeSanction(Sanction $sanction): self
    {
        $this->sanction->removeElement($sanction);

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

    public function getAutreAgression(): ?string
    {
        return $this->autreAgression;
    }

    public function setAutreAgression(?string $autreAgression): self
    {
        $this->autreAgression = $autreAgression;

        return $this;
    }

    public function getSansSuite(): ?float
    {
        return $this->sansSuite;
    }

    public function setSansSuite(?float $sansSuite): self
    {
        $this->sansSuite = $sansSuite;

        return $this;
    }
}
