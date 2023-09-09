<?php

namespace App\Entity;

use App\Repository\HAlbhonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HAlbhonRepository::class)]
class HAlbhon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\ManyToOne(targetEntity: semaine::class, inversedBy: 'albhonss')]
    private $semaine;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'albhonss')]
    private $userCreated;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'albhonss')]
    private $userUpdated;

    #[ORM\ManyToOne(targetEntity: AcPromotion::class, inversedBy: 'albhonss')]
    private $promotion;

    #[ORM\OneToMany(mappedBy: 'bordereau', targetEntity: HHonens::class)]
    private $honenss;

    public function __construct()
    {
        $this->honenss = new ArrayCollection();
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

    public function getSemaine(): ?semaine
    {
        return $this->semaine;
    }

    public function setSemaine(?semaine $semaine): self
    {
        $this->semaine = $semaine;

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

    public function getUserUpdated(): ?User
    {
        return $this->userUpdated;
    }

    public function setUserUpdated(?User $userUpdated): self
    {
        $this->userUpdated = $userUpdated;

        return $this;
    }

    public function getPromotion(): ?AcPromotion
    {
        return $this->promotion;
    }

    public function setPromotion(?AcPromotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * @return Collection<int, HHonens>
     */
    public function getHonenss(): Collection
    {
        return $this->honenss;
    }

    public function addHonenss(HHonens $honenss): self
    {
        if (!$this->honenss->contains($honenss)) {
            $this->honenss[] = $honenss;
            $honenss->setBordereau($this);
        }

        return $this;
    }

    public function removeHonenss(HHonens $honenss): self
    {
        if ($this->honenss->removeElement($honenss)) {
            // set the owning side to null (unless already changed)
            if ($honenss->getBordereau() === $this) {
                $honenss->setBordereau(null);
            }
        }

        return $this;
    }
}
