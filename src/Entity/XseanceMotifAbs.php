<?php

namespace App\Entity;

use App\Repository\XseanceMotifAbsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XseanceMotifAbsRepository::class)]
class XseanceMotifAbs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Motif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotif(): ?string
    {
        return $this->Motif;
    }

    public function setMotif(?string $Motif): self
    {
        $this->Motif = $Motif;

        return $this;
    }
}
