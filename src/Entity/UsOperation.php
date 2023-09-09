<?php

namespace App\Entity;

use App\Repository\UsOperationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsOperationRepository::class)]
class UsOperation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $link;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $icon;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $classTag;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $idTag;

    #[ORM\ManyToOne(targetEntity: UsSousModule::class, inversedBy: 'operations')]
    private $sousModule;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'operations')]
    private $users;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $ordre;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

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

    public function getClassTag(): ?string
    {
        return $this->classTag;
    }

    public function setClassTag(?string $classTag): self
    {
        $this->classTag = $classTag;

        return $this;
    }

    public function getIdTag(): ?string
    {
        return $this->idTag;
    }

    public function setIdTag(?string $idTag): self
    {
        $this->idTag = $idTag;

        return $this;
    }

    public function getSousModule(): ?UsSousModule
    {
        return $this->sousModule;
    }

    public function setSousModule(?UsSousModule $sousModule): self
    {
        $this->sousModule = $sousModule;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addOperation($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeOperation($this);
        }

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(?int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }
}
