<?php

namespace App\Entity;

use App\Repository\XseanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XseanceRepository::class)]
class Xseance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Feuillea;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $ID_Séance;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Typeséance;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Etablissement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Formation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Promotion;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Année;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Année_Lib;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Semestre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Groupe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Module;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Element;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Enseignant;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ID_Salle;

    #[ORM\Column(type: 'date', nullable: true)]
    private $Date_Séance;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $semaine;

    #[ORM\Column(type: 'time', nullable: true)]
    private $Heure_Debut;

    #[ORM\Column(type: 'time', nullable: true)]
    private $Heure_Fin;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Traitement;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Cloturer;

    #[ORM\Column(type: 'date', nullable: true)]
    private $Date_Sys;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Statut;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Existe;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Signé;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Annulée;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIDFeuilleA(): ?string
    {
        return $this->ID_Feuillea;
    }

    public function setIDFeuilleA(?string $ID_Feuillea): self
    {
        $this->ID_Feuillea = $ID_Feuillea;

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

    public function getTypeséance(): ?string
    {
        return $this->Typeséance;
    }

    public function setTypeséance(?string $Typeséance): self
    {
        $this->Typeséance = $Typeséance;

        return $this;
    }

    public function getIDEtablissement(): ?string
    {
        return $this->ID_Etablissement;
    }

    public function setIDEtablissement(?string $ID_Etablissement): self
    {
        $this->ID_Etablissement = $ID_Etablissement;

        return $this;
    }

    public function getIDFormation(): ?string
    {
        return $this->ID_Formation;
    }

    public function setIDFormation(?string $ID_Formation): self
    {
        $this->ID_Formation = $ID_Formation;

        return $this;
    }

    public function getIDPromotion(): ?string
    {
        return $this->ID_Promotion;
    }

    public function setIDPromotion(?string $ID_Promotion): self
    {
        $this->ID_Promotion = $ID_Promotion;

        return $this;
    }

    public function getIDAnnée(): ?string
    {
        return $this->ID_Année;
    }

    public function setIDAnnée(?string $ID_Année): self
    {
        $this->ID_Année = $ID_Année;

        return $this;
    }

    public function getAnnéeLib(): ?string
    {
        return $this->Année_Lib;
    }

    public function setAnnéeLib(?string $Année_Lib): self
    {
        $this->Année_Lib = $Année_Lib;

        return $this;
    }

    public function getIDSemestre(): ?string
    {
        return $this->ID_Semestre;
    }

    public function setIDSemestre(?string $ID_Semestre): self
    {
        $this->ID_Semestre = $ID_Semestre;

        return $this;
    }

    public function getGroupe(): ?string
    {
        return $this->Groupe;
    }

    public function setGroupe(?string $Groupe): self
    {
        $this->Groupe = $Groupe;

        return $this;
    }

    public function getIDModule(): ?string
    {
        return $this->ID_Module;
    }

    public function setIDModule(?string $ID_Module): self
    {
        $this->ID_Module = $ID_Module;

        return $this;
    }

    public function getIDElement(): ?string
    {
        return $this->ID_Element;
    }

    public function setIDElement(?string $ID_Element): self
    {
        $this->ID_Element = $ID_Element;

        return $this;
    }

    public function getIDEnseignant(): ?string
    {
        return $this->ID_Enseignant;
    }

    public function setIDEnseignant(?string $ID_Enseignant): self
    {
        $this->ID_Enseignant = $ID_Enseignant;

        return $this;
    }

    public function getIDSalle(): ?string
    {
        return $this->ID_Salle;
    }

    public function setIDSalle(?string $ID_Salle): self
    {
        $this->ID_Salle = $ID_Salle;

        return $this;
    }

    public function getDateSéance(): ?\DateTimeInterface
    {
        return $this->Date_Séance;
    }

    public function setDateSéance(?\DateTimeInterface $Date_Séance): self
    {
        $this->Date_Séance = $Date_Séance;

        return $this;
    }

    public function getSemaine(): ?int
    {
        return $this->semaine;
    }

    public function setSemaine(?int $semaine): self
    {
        $this->semaine = $semaine;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->Heure_Debut;
    }

    public function setHeureDebut(?\DateTimeInterface $Heure_Debut): self
    {
        $this->Heure_Debut = $Heure_Debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->Heure_Fin;
    }

    public function setHeureFin(?\DateTimeInterface $Heure_Fin): self
    {
        $this->Heure_Fin = $Heure_Fin;

        return $this;
    }

    public function getTraitement(): ?int
    {
        return $this->Traitement;
    }

    public function setTraitement(?int $Traitement): self
    {
        $this->Traitement = $Traitement;

        return $this;
    }

    public function getCloturer(): ?int
    {
        return $this->Cloturer;
    }

    public function setCloturer(?int $Cloturer): self
    {
        $this->Cloturer = $Cloturer;

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

    public function getStatut(): ?int
    {
        return $this->Statut;
    }

    public function setStatut(?int $Statut): self
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getExiste(): ?int
    {
        return $this->Existe;
    }

    public function setExiste(?int $Existe): self
    {
        $this->Existe = $Existe;

        return $this;
    }

    public function getSigné(): ?int
    {
        return $this->Signé;
    }

    public function setSigné(?int $Signé): self
    {
        $this->Signé = $Signé;

        return $this;
    }

    public function getAnnulée(): ?int
    {
        return $this->Annulée;
    }

    public function setAnnulée(?int $Annulée): self
    {
        $this->Annulée = $Annulée;

        return $this;
    }
}
