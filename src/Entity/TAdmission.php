<?php

namespace App\Entity;

use App\Repository\TAdmissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TAdmissionRepository::class)]
class TAdmission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PStatut::class, inversedBy: 'admissions')]
    private $statut;

    #[ORM\ManyToOne(targetEntity: TPreinscription::class, inversedBy: 'admissions')]
    private $preinscription;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userCreated;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userUpdated;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $fermer;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\OneToMany(mappedBy: 'admission', targetEntity: TInscription::class)]
    private $inscriptions;

    #[ORM\OneToMany(mappedBy: 'admission', targetEntity: AnoteExterne::class)]
    private $anoteExternes;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->anoteExternes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?PStatut
    {
        return $this->statut;
    }

    public function setStatut(?PStatut $statut): self
    {
        $this->statut = $statut;

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

    public function getUserCreated(): ?user
    {
        return $this->userCreated;
    }

    public function setUserCreated(?user $userCreated): self
    {
        $this->userCreated = $userCreated;

        return $this;
    }

    public function getUserUpdated(): ?user
    {
        return $this->userUpdated;
    }

    public function setUserUpdated(?user $userUpdated): self
    {
        $this->userUpdated = $userUpdated;

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

    public function getFermer(): ?int
    {
        return $this->fermer;
    }

    public function setFermer(?int $fermer): self
    {
        $this->fermer = $fermer;

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
     * @return Collection|TInscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(TInscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setAdmission($this);
        }

        return $this;
    }

    public function removeInscription(TInscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getAdmission() === $this) {
                $inscription->setAdmission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnoteExterne>
     */
    public function getAnoteExternes(): Collection
    {
        return $this->anoteExternes;
    }

    public function addAnoteExterne(AnoteExterne $anoteExterne): self
    {
        if (!$this->anoteExternes->contains($anoteExterne)) {
            $this->anoteExternes[] = $anoteExterne;
            $anoteExterne->setAdmission($this);
        }

        return $this;
    }

    public function removeAnoteExterne(AnoteExterne $anoteExterne): self
    {
        if ($this->anoteExternes->removeElement($anoteExterne)) {
            // set the owning side to null (unless already changed)
            if ($anoteExterne->getAdmission() === $this) {
                $anoteExterne->setAdmission(null);
            }
        }

        return $this;
    }
}
