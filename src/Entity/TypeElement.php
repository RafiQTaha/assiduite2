<?php

namespace App\Entity;

use App\Repository\TypeElementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeElementRepository::class)]
class TypeElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $designation;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\OneToMany(mappedBy: 'nature', targetEntity: AcElement::class)]
    private $elements;

    public function __construct()
    {
        // $this->elements = new ArrayCollection();
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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return Collection<int, AcElement>
     */
    public function getElements(): Collection
    {
        return $this->elements;
    }

    public function addElement(AcElement $element): self
    {
        if (!$this->elements->contains($element)) {
            $this->elements[] = $element;
            $element->setNature($this);
        }

        return $this;
    }

    public function removeElement(AcElement $element): self
    {
        if ($this->elements->removeElement($element)) {
            // set the owning side to null (unless already changed)
            if ($element->getNature() === $this) {
                $element->setNature(null);
            }
        }

        return $this;
    }
}
