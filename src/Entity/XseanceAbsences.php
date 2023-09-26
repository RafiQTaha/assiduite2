<?php

namespace App\Entity;

use App\Repository\XseanceAbsencesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XseanceAbsencesRepository::class)]
class XseanceAbsences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Admission;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $ID_Séance;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $ID_User;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Prénom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Groupe_Stage;

    #[ORM\Column(type: 'date', nullable: true)]
    private $Date_Pointage;

    #[ORM\Column(type: 'time', nullable: true)]
    private $Heure_Pointage;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Retard;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Categorie;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Categorie_Enseig;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $Justifier;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $ID_Justif;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $Motif;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Comptabilisé;

    #[ORM\Column(type: 'date', nullable: true)]
    private $Date_Sys;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Obs;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Categorie_si;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Categorie_f;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIDAdmission(): ?string
    {
        return $this->ID_Admission;
    }

    public function setIDAdmission(?string $ID_Admission): self
    {
        $this->ID_Admission = $ID_Admission;

        return $this;
    }

    public function getIDSéance(): ?int
    {
        return $this->ID_Séance;
    }

    public function setIDSéance(?int $ID_Séance): self
    {
        $this->ID_Séance = $ID_Séance;

        return $this;
    }

    public function getIDUser(): ?int
    {
        return $this->ID_User;
    }

    public function setIDUser(?int $ID_User): self
    {
        $this->ID_User = $ID_User;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrénom(): ?string
    {
        return $this->Prénom;
    }

    public function setPrénom(?string $Prénom): self
    {
        $this->Prénom = $Prénom;

        return $this;
    }

    public function getIDGroupeStage(): ?string
    {
        return $this->ID_Groupe_Stage;
    }

    public function setIDGroupeStage(?string $ID_Groupe_Stage): self
    {
        $this->ID_Groupe_Stage = $ID_Groupe_Stage;

        return $this;
    }

    public function getDatePointage(): ?\DateTimeInterface
    {
        return $this->Date_Pointage;
    }

    public function setDatePointage(?\DateTimeInterface $Date_Pointage): self
    {
        $this->Date_Pointage = $Date_Pointage;

        return $this;
    }

    public function getHeurePointage(): ?\DateTimeInterface
    {
        return $this->Heure_Pointage;
    }

    public function setHeurePointage(?\DateTimeInterface $Heure_Pointage): self
    {
        $this->Heure_Pointage = $Heure_Pointage;

        return $this;
    }

    public function getRetard(): ?string
    {
        return $this->Retard;
    }

    public function setRetard(?string $Retard): self
    {
        $this->Retard = $Retard;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->Categorie;
    }

    public function setCategorie(?string $Categorie): self
    {
        $this->Categorie = $Categorie;

        return $this;
    }

    public function getCategorieEnseig(): ?string
    {
        return $this->Categorie_Enseig;
    }

    public function setCategorieEnseig(?string $Categorie_Enseig): self
    {
        $this->Categorie_Enseig = $Categorie_Enseig;

        return $this;
    }

    public function getJustifier(): ?int
    {
        return $this->Justifier;
    }

    public function setJustifier(?int $Justifier): self
    {
        $this->Justifier = $Justifier;

        return $this;
    }

    public function getIDJustif(): ?int
    {
        return $this->ID_Justif;
    }

    public function setIDJustif(?int $ID_Justif): self
    {
        $this->ID_Justif = $ID_Justif;

        return $this;
    }

    public function getMotif(): ?int
    {
        return $this->Motif;
    }

    public function setMotif(?int $Motif): self
    {
        $this->Motif = $Motif;

        return $this;
    }

    public function getComptabilisé(): ?int
    {
        return $this->Comptabilisé;
    }

    public function setComptabilisé(?int $Comptabilisé): self
    {
        $this->Comptabilisé = $Comptabilisé;

        return $this;
    }

    public function getDateSys(): ?\DateTimeInterface
    {
        return $this->Date_Sys;
    }

    public function setDateSys(?\DateTimeInterface $Date_Sys): self
    {
        $this->Date_Sys = $Date_Sys;

        return $this;
    }

    public function getObs(): ?string
    {
        return $this->Obs;
    }

    public function setObs(?string $Obs): self
    {
        $this->Obs = $Obs;

        return $this;
    }

    public function getCategorieSi(): ?string
    {
        return $this->Categorie_si;
    }

    public function setCategorieSi(?string $Categorie_si): self
    {
        $this->Categorie_si = $Categorie_si;

        return $this;
    }

    public function getCategorieF(): ?string
    {
        return $this->Categorie_f;
    }

    public function setCategorieF(?string $Categorie_f): self
    {
        $this->Categorie_f = $Categorie_f;

        return $this;
    }
    
    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(?int $active): self
    {
        $this->active = $active;

        return $this;
    }
}
