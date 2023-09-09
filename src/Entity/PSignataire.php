<?php

namespace App\Entity;

use App\Repository\PSignataireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PSignataireRepository::class)]
class PSignataire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\OneToMany(mappedBy: 'signataire', targetEntity: DDiplomes::class)]
    private $dDiplomes;

    public function __construct()
    {
        $this->dDiplomes = new ArrayCollection();
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

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection<int, DDiplomes>
     */
    public function getDDiplomes(): Collection
    {
        return $this->dDiplomes;
    }

    public function addDDiplome(DDiplomes $dDiplome): self
    {
        if (!$this->dDiplomes->contains($dDiplome)) {
            $this->dDiplomes[] = $dDiplome;
            $dDiplome->setSignataire($this);
        }

        return $this;
    }

    public function removeDDiplome(DDiplomes $dDiplome): self
    {
        if ($this->dDiplomes->removeElement($dDiplome)) {
            // set the owning side to null (unless already changed)
            if ($dDiplome->getSignataire() === $this) {
                $dDiplome->setSignataire(null);
            }
        }

        return $this;
    }
}
