<?php

namespace App\Entity;

use App\Repository\TOperationdetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TOperationdetRepository::class)]
class TOperationdet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: TOperationcab::class, inversedBy: 'operationdets')]
    private $operationcab;

    #[ORM\ManyToOne(targetEntity: PFrais::class, inversedBy: 'operationdets')]
    private $frais;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'float', nullable: true)]
    private $montant;

    #[ORM\Column(type: 'float', nullable: true)]
    private $remise;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ice;

    #[ORM\Column(type: 'float', nullable: true)]
    private $active;

    #[ORM\ManyToOne(targetEntity: POrganisme::class, inversedBy: 'operationdets')]
    private $organisme;

    #[ORM\Column(type: 'float', nullable: true)]
    private $synFlag = 0;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tOperationDets')]
    private $userCreated;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tOperationdets')]
    private $userUpdated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperationcab(): ?TOperationcab
    {
        return $this->operationcab;
    }

    public function setOperationcab(?TOperationcab $operationcab): self
    {
        $this->operationcab = $operationcab;

        return $this;
    }

    public function getFrais(): ?PFrais
    {
        return $this->frais;
    }

    public function setFrais(?PFrais $frais): self
    {
        $this->frais = $frais;

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

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getRemise(): ?float
    {
        return $this->remise;
    }

    public function setRemise(?float $remise): self
    {
        $this->remise = $remise;

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

    public function getIce(): ?string
    {
        return $this->ice;
    }

    public function setIce(?string $ice): self
    {
        $this->ice = $ice;

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

    public function getOrganisme(): ?POrganisme
    {
        return $this->organisme;
    }

    public function setOrganisme(?POrganisme $organisme): self
    {
        $this->organisme = $organisme;

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
}
