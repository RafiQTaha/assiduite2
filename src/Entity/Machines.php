<?php

namespace App\Entity;

use App\Repository\MachinesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MachinesRepository::class)]
class Machines
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $MachineAlias;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $IP;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $sn;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMachineAlias(): ?string
    {
        return $this->MachineAlias;
    }

    public function setMachineAlias(?string $MachineAlias): self
    {
        $this->MachineAlias = $MachineAlias;

        return $this;
    }

    public function getIP(): ?string
    {
        return $this->IP;
    }

    public function setIP(?string $IP): self
    {
        $this->IP = $IP;

        return $this;
    }

    public function getSn(): ?string
    {
        return $this->sn;
    }

    public function setSn(?string $sn): self
    {
        $this->sn = $sn;

        return $this;
    }
}
