<?php

namespace App\Entity;

use App\Repository\UsModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsModuleRepository::class)]
class UsModule
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
    private $class;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prefix;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: UsSousModule::class)]
    private $sousModule;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $ordre;

    public function __construct()
    {
        $this->sousModule = new ArrayCollection();
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

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(?string $class): self
    {
        $this->class = $class;

        return $this;
    }

   
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function setPrefix(?string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return Collection|UsSousModule[]
     */
    public function getSousModule(): Collection
    {
        return $this->sousModule;
    }

    public function addSousModule(UsSousModule $sousModule): self
    {
        if (!$this->sousModule->contains($sousModule)) {
            $this->sousModule[] = $sousModule;
            $sousModule->setModule($this);
        }

        return $this;
    }

    public function removeSousModule(UsSousModule $sousModule): self
    {
        if ($this->sousModule->removeElement($sousModule)) {
            // set the owning side to null (unless already changed)
            if ($sousModule->getModule() === $this) {
                $sousModule->setModule(null);
            }
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
