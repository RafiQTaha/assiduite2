<?php

namespace App\Entity;

use App\Repository\TInscriptionImpControleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TInscriptionImpControleRepository::class)]
class TInscriptionImpControle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: TInscription::class, inversedBy: 'tInscriptionImpControles')]
    private $inscription;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $controle;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isRattrapage;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tInscriptionImpControles')]
    private $userCreated;

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

    public function getControle(): ?int
    {
        return $this->controle;
    }

    public function setControle(?int $controle): self
    {
        $this->controle = $controle;

        return $this;
    }

    public function isIsRattrapage(): ?bool
    {
        return $this->isRattrapage;
    }

    public function setIsRattrapage(?bool $isRattrapage): self
    {
        $this->isRattrapage = $isRattrapage;

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
}
