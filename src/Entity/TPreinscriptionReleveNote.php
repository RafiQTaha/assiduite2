<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TPreinscriptionReleveNoteRepository;

#[ORM\Entity(repositoryClass: TPreinscriptionReleveNoteRepository::class)]
class TPreinscriptionReleveNote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PMatiere::class, inversedBy: 'tPreinscritionReleveNotes')]
    private $matiere;

    #[ORM\ManyToOne(targetEntity: TEtudiant::class, inversedBy: 'tPreinscritionReleveNotes')]
    private $etudiant;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userCreated;

    #[ORM\Column(type: 'float', nullable: true)]
    private $note;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatiere(): ?PMatiere
    {
        return $this->matiere;
    }

    public function setMatiere(?PMatiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getEtudiant(): ?TEtudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?TEtudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

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

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): self
    {
        $this->note = $note;

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
}
