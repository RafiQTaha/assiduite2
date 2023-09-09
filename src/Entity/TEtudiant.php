<?php

namespace App\Entity;

use App\Repository\TEtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TEtudiantRepository::class)]
class TEtudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: PSituation::class)]
    private $stFamille;

    #[ORM\ManyToOne(targetEntity: PSituation::class)]
    private $stFamilleParent;

    #[ORM\ManyToOne(targetEntity: PStatut::class, inversedBy: 'etudiants')]
    private $statut;

    #[ORM\ManyToOne(targetEntity: NatureDemande::class, inversedBy: 'etudiants')]
    private $natureDemande;

    #[ORM\ManyToOne(targetEntity: XTypeBac::class, inversedBy: 'etudiants')]
    private $typeBac;

    #[ORM\ManyToOne(targetEntity: XAcademie::class, inversedBy: 'etudiants')]
    private $academie;

    #[ORM\ManyToOne(targetEntity: XLangue::class, inversedBy: 'etudiants')]
    private $langueConcours;

    #[ORM\ManyToOne(targetEntity: XFiliere::class, inversedBy: 'etudiants')]
    private $filiere;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userCreated;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $userUpdated;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $urlImage;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $titre;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateNaissance;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lieuNaissance;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $sexe;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $nationalite;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $cin;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $passeport;

    #[ORM\Column(type: 'text', nullable: true)]
    private $adresse;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $ville;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $tel1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $tel2;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $tel3;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $mail1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $mail2;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nomPere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prenomPere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nationalitePere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $professionPere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $employePere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $categoriePere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telPere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $mailPere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $salairePere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nomMere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prenomMere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nationaliteMere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $professionMere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $employeMere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $categorieMere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telMere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $mailMere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $salaireMere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cne;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $anneeBac;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $moyenneBac;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $concoursMedbup;

    #[ORM\Column(type: 'text', nullable: true)]
    private $obs;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $categoriePreinscription;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $fraisPreinscription;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $bourse;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $logement;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $parking;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $actif;

    #[ORM\Column(type: 'string', length: 11, nullable: true)]
    private $nombreEnfants;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $categorieListe;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $admissionListe;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $teleListe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $statutDeliberation;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $active;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $cpgem;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $cpge1;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $cpge2;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $vet;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $cam;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $ist;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $ip;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $fpa;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $fda;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $fma;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $sourceSite;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: TPreinscription::class)]
    private $preinscriptions;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $eia;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $etablissement;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: TPreinscriptionReleveNote::class)]
    private $tPreinscritionReleveNotes;

    #[ORM\ManyToOne(targetEntity: POrganisme::class, inversedBy: 'etudiants')]
    private $organisme;

    #[ORM\Column(type: 'date', nullable: true)]
    private $rdv1;

    #[ORM\Column(type: 'date', nullable: true)]
    private $rdv2;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $moyen_regional;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $moyen_national;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tEtudiants')]
    private $operateur;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $choix;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $strange = 0;

    #[ORM\Column(type: 'float', nullable: true)]
    private $statutAppel;

    #[ORM\Column(type: 'string', length: 25, nullable: true)]
    private $statutCondidat;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private $statutRdv;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $rdv;

    #[ORM\ManyToOne(targetEntity: AcFormation::class, inversedBy: 'tEtudiants')]
    private $formationSouhaitee;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $codeAssurance;

    public function __construct()
    {
        $this->preinscriptions = new ArrayCollection();
        $this->tPreinscritionReleveNotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStFamille(): ?PSituation
    {
        return $this->stFamille;
    }

    public function setStFamille(?PSituation $stFamille): self
    {
        $this->stFamille = $stFamille;

        return $this;
    }

    public function getStFamilleParent(): ?PSituation
    {
        return $this->stFamilleParent;
    }

    public function setStFamilleParent(?PSituation $stFamilleParent): self
    {
        $this->stFamilleParent = $stFamilleParent;

        return $this;
    }

    public function getStatut(): ?PStatut
    {
        return $this->statut;
    }

    public function setStatut(?PStatut $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getNatureDemande(): ?NatureDemande
    {
        return $this->natureDemande;
    }

    public function setNatureDemande(?NatureDemande $natureDemande): self
    {
        $this->natureDemande = $natureDemande;

        return $this;
    }

    public function getTypeBac(): ?XTypeBac
    {
        return $this->typeBac;
    }

    public function setTypeBac(?XTypeBac $typeBac): self
    {
        $this->typeBac = $typeBac;

        return $this;
    }

    public function getAcademie(): ?XAcademie
    {
        return $this->academie;
    }

    public function setAcademie(?XAcademie $academie): self
    {
        $this->academie = $academie;

        return $this;
    }

    public function getLangueConcours(): ?XLangue
    {
        return $this->langueConcours;
    }

    public function setLangueConcours(?XLangue $langueConcours): self
    {
        $this->langueConcours = $langueConcours;

        return $this;
    }

    public function getFiliere(): ?XFiliere
    {
        return $this->filiere;
    }

    public function setFiliere(?XFiliere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getUserCreated(): ?user
    {
        return $this->userCreated;
    }

    public function setUserCreated(?user $userCreated): self
    {
        $this->userCreated = $userCreated;

        return $this;
    }

    public function getUserUpdated(): ?user
    {
        return $this->userUpdated;
    }

    public function setUserUpdated(?user $userUpdated): self
    {
        $this->userUpdated = $userUpdated;

        return $this;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getUrlImage(): ?string
    {
        return $this->urlImage;
    }

    public function setUrlImage(?string $urlImage): self
    {
        $this->urlImage = $urlImage;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(?string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(?string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(?string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getPasseport(): ?string
    {
        return $this->passeport;
    }

    public function setPasseport(?string $passeport): self
    {
        $this->passeport = $passeport;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTel1(): ?string
    {
        return $this->tel1;
    }

    public function setTel1(?string $tel1): self
    {
        $this->tel1 = $tel1;

        return $this;
    }

    public function getTel2(): ?string
    {
        return $this->tel2;
    }

    public function setTel2(?string $tel2): self
    {
        $this->tel2 = $tel2;

        return $this;
    }

    public function getTel3(): ?string
    {
        return $this->tel3;
    }

    public function setTel3(?string $tel3): self
    {
        $this->tel3 = $tel3;

        return $this;
    }

    public function getMail1(): ?string
    {
        return $this->mail1;
    }

    public function setMail1(?string $mail1): self
    {
        $this->mail1 = $mail1;

        return $this;
    }

    public function getMail2(): ?string
    {
        return $this->mail2;
    }

    public function setMail2(?string $mail2): self
    {
        $this->mail2 = $mail2;

        return $this;
    }

    public function getNomPere(): ?string
    {
        return $this->nomPere;
    }

    public function setNomPere(?string $nomPere): self
    {
        $this->nomPere = $nomPere;

        return $this;
    }

    public function getPrenomPere(): ?string
    {
        return $this->prenomPere;
    }

    public function setPrenomPere(?string $prenomPere): self
    {
        $this->prenomPere = $prenomPere;

        return $this;
    }

    public function getNationalitePere(): ?string
    {
        return $this->nationalitePere;
    }

    public function setNationalitePere(?string $nationalitePere): self
    {
        $this->nationalitePere = $nationalitePere;

        return $this;
    }

    public function getProfessionPere(): ?string
    {
        return $this->professionPere;
    }

    public function setProfessionPere(?string $professionPere): self
    {
        $this->professionPere = $professionPere;

        return $this;
    }

    public function getEmployePere(): ?string
    {
        return $this->employePere;
    }

    public function setEmployePere(?string $employePere): self
    {
        $this->employePere = $employePere;

        return $this;
    }

    public function getCategoriePere(): ?string
    {
        return $this->categoriePere;
    }

    public function setCategoriePere(?string $categoriePere): self
    {
        $this->categoriePere = $categoriePere;

        return $this;
    }

    public function getTelPere(): ?string
    {
        return $this->telPere;
    }

    public function setTelPere(?string $telPere): self
    {
        $this->telPere = $telPere;

        return $this;
    }

    public function getMailPere(): ?string
    {
        return $this->mailPere;
    }

    public function setMailPere(?string $mailPere): self
    {
        $this->mailPere = $mailPere;

        return $this;
    }

    public function getSalairePere(): ?string
    {
        return $this->salairePere;
    }

    public function setSalairePere(?string $salairePere): self
    {
        $this->salairePere = $salairePere;

        return $this;
    }

    public function getNomMere(): ?string
    {
        return $this->nomMere;
    }

    public function setNomMere(?string $nomMere): self
    {
        $this->nomMere = $nomMere;

        return $this;
    }

    public function getPrenomMere(): ?string
    {
        return $this->prenomMere;
    }

    public function setPrenomMere(?string $prenomMere): self
    {
        $this->prenomMere = $prenomMere;

        return $this;
    }

    public function getNationaliteMere(): ?string
    {
        return $this->nationaliteMere;
    }

    public function setNationaliteMere(?string $nationaliteMere): self
    {
        $this->nationaliteMere = $nationaliteMere;

        return $this;
    }

    public function getProfessionMere(): ?string
    {
        return $this->professionMere;
    }

    public function setProfessionMere(?string $professionMere): self
    {
        $this->professionMere = $professionMere;

        return $this;
    }

    public function getEmployeMere(): ?string
    {
        return $this->employeMere;
    }

    public function setEmployeMere(?string $employeMere): self
    {
        $this->employeMere = $employeMere;

        return $this;
    }

    public function getCategorieMere(): ?string
    {
        return $this->categorieMere;
    }

    public function setCategorieMere(?string $categorieMere): self
    {
        $this->categorieMere = $categorieMere;

        return $this;
    }

    public function getTelMere(): ?string
    {
        return $this->telMere;
    }

    public function setTelMere(?string $telMere): self
    {
        $this->telMere = $telMere;

        return $this;
    }

    public function getMailMere(): ?string
    {
        return $this->mailMere;
    }

    public function setMailMere(?string $mailMere): self
    {
        $this->mailMere = $mailMere;

        return $this;
    }

    public function getSalaireMere(): ?string
    {
        return $this->salaireMere;
    }

    public function setSalaireMere(?string $salaireMere): self
    {
        $this->salaireMere = $salaireMere;

        return $this;
    }

    public function getCne(): ?string
    {
        return $this->cne;
    }

    public function setCne(?string $cne): self
    {
        $this->cne = $cne;

        return $this;
    }

    public function getAnneeBac(): ?string
    {
        return $this->anneeBac;
    }

    public function setAnneeBac(?string $anneeBac): self
    {
        $this->anneeBac = $anneeBac;

        return $this;
    }

    public function getMoyenneBac(): ?string
    {
        return $this->moyenneBac;
    }

    public function setMoyenneBac(?string $moyenneBac): self
    {
        $this->moyenneBac = $moyenneBac;

        return $this;
    }

    public function getConcoursMedbup(): ?string
    {
        return $this->concoursMedbup;
    }

    public function setConcoursMedbup(?string $concoursMedbup): self
    {
        $this->concoursMedbup = $concoursMedbup;

        return $this;
    }

    public function getObs(): ?string
    {
        return $this->obs;
    }

    public function setObs(?string $obs): self
    {
        $this->obs = $obs;

        return $this;
    }

    public function getCategoriePreinscription(): ?string
    {
        return $this->categoriePreinscription;
    }

    public function setCategoriePreinscription(?string $categoriePreinscription): self
    {
        $this->categoriePreinscription = $categoriePreinscription;

        return $this;
    }

    public function getFraisPreinscription(): ?string
    {
        return $this->fraisPreinscription;
    }

    public function setFraisPreinscription(?string $fraisPreinscription): self
    {
        $this->fraisPreinscription = $fraisPreinscription;

        return $this;
    }

    public function getBourse(): ?string
    {
        return $this->bourse;
    }

    public function setBourse(?string $bourse): self
    {
        $this->bourse = $bourse;

        return $this;
    }

    public function getLogement(): ?string
    {
        return $this->logement;
    }

    public function setLogement(?string $logement): self
    {
        $this->logement = $logement;

        return $this;
    }

    public function getParking(): ?string
    {
        return $this->parking;
    }

    public function setParking(?string $parking): self
    {
        $this->parking = $parking;

        return $this;
    }

    public function getActif(): ?string
    {
        return $this->actif;
    }

    public function setActif(?string $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getNombreEnfants(): ?string
    {
        return $this->nombreEnfants;
    }

    public function setNombreEnfants(?string $nombreEnfants): self
    {
        $this->nombreEnfants = $nombreEnfants;

        return $this;
    }

    public function getCategorieListe(): ?string
    {
        return $this->categorieListe;
    }

    public function setCategorieListe(?string $categorieListe): self
    {
        $this->categorieListe = $categorieListe;

        return $this;
    }

    public function getAdmissionListe(): ?string
    {
        return $this->admissionListe;
    }

    public function setAdmissionListe(?string $admissionListe): self
    {
        $this->admissionListe = $admissionListe;

        return $this;
    }

    public function getTeleListe(): ?string
    {
        return $this->teleListe;
    }

    public function setTeleListe(?string $teleListe): self
    {
        $this->teleListe = $teleListe;

        return $this;
    }

    public function getStatutDeliberation(): ?string
    {
        return $this->statutDeliberation;
    }

    public function setStatutDeliberation(?string $statutDeliberation): self
    {
        $this->statutDeliberation = $statutDeliberation;

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

    public function getCpgem(): ?int
    {
        return $this->cpgem;
    }

    public function setCpgem(?int $cpgem): self
    {
        $this->cpgem = $cpgem;

        return $this;
    }

    public function getCpge1(): ?int
    {
        return $this->cpge1;
    }

    public function setCpge1(?int $cpge1): self
    {
        $this->cpge1 = $cpge1;

        return $this;
    }

    public function getCpge2(): ?int
    {
        return $this->cpge2;
    }

    public function setCpge2(?int $cpge2): self
    {
        $this->cpge2 = $cpge2;

        return $this;
    }

    public function getVet(): ?int
    {
        return $this->vet;
    }

    public function setVet(?int $vet): self
    {
        $this->vet = $vet;

        return $this;
    }

    public function getCam(): ?int
    {
        return $this->cam;
    }

    public function setCam(?int $cam): self
    {
        $this->cam = $cam;

        return $this;
    }

    public function getIst(): ?int
    {
        return $this->ist;
    }

    public function setIst(?int $ist): self
    {
        $this->ist = $ist;

        return $this;
    }

    public function getIp(): ?int
    {
        return $this->ip;
    }

    public function setIp(?int $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getFpa(): ?int
    {
        return $this->fpa;
    }

    public function setFpa(?int $fpa): self
    {
        $this->fpa = $fpa;

        return $this;
    }

    public function getFda(): ?int
    {
        return $this->fda;
    }

    public function setFda(?int $fda): self
    {
        $this->fda = $fda;

        return $this;
    }

    public function getFma(): ?int
    {
        return $this->fma;
    }

    public function setFma(?int $fma): self
    {
        $this->fma = $fma;

        return $this;
    }

    public function getSourceSite(): ?int
    {
        return $this->sourceSite;
    }

    public function setSourceSite(?int $sourceSite): self
    {
        $this->sourceSite = $sourceSite;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
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

    /**
     * @return Collection|TPreinscription[]
     */
    public function getPreinscriptions(): Collection
    {
        return $this->preinscriptions;
    }

    public function addPreinscription(TPreinscription $preinscription): self
    {
        if (!$this->preinscriptions->contains($preinscription)) {
            $this->preinscriptions[] = $preinscription;
            $preinscription->setEtudiant($this);
        }

        return $this;
    }

    public function removePreinscription(TPreinscription $preinscription): self
    {
        if ($this->preinscriptions->removeElement($preinscription)) {
            // set the owning side to null (unless already changed)
            if ($preinscription->getEtudiant() === $this) {
                $preinscription->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getEia(): ?int
    {
        return $this->eia;
    }

    public function setEia(?int $eia): self
    {
        $this->eia = $eia;

        return $this;
    }

    public function getEtablissement(): ?string
    {
        return $this->etablissement;
    }

    public function setEtablissement(?string $etablissement): self
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * @return Collection|TPreinscriptionReleveNote[]
     */
    public function getTPreinscritionReleveNotes(): Collection
    {
        return $this->tPreinscritionReleveNotes;
    }

    public function addTPreinscritionReleveNote(TPreinscriptionReleveNote $tPreinscritionReleveNote): self
    {
        if (!$this->tPreinscritionReleveNotes->contains($tPreinscritionReleveNote)) {
            $this->tPreinscritionReleveNotes[] = $tPreinscritionReleveNote;
            $tPreinscritionReleveNote->setEtudiant($this);
        }

        return $this;
    }

    public function removeTPreinscritionReleveNote(TPreinscriptionReleveNote $tPreinscritionReleveNote): self
    {
        if ($this->tPreinscritionReleveNotes->removeElement($tPreinscritionReleveNote)) {
            // set the owning side to null (unless already changed)
            if ($tPreinscritionReleveNote->getEtudiant() === $this) {
                $tPreinscritionReleveNote->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getOrganisme(): ?POrganisme
    {
        return $this->organisme;
    }

    public function setOrganisme(?POrganisme $organisme): self
    {
        $this->organisme = $organisme;

        return $this;
    }

    public function getRdv1(): ?\DateTimeInterface
    {
        return $this->rdv1;
    }

    public function setRdv1(?\DateTimeInterface $rdv1): self
    {
        $this->rdv1 = $rdv1;

        return $this;
    }

    public function getRdv2(): ?\DateTimeInterface
    {
        return $this->rdv2;
    }

    public function setRdv2(?\DateTimeInterface $rdv2): self
    {
        $this->rdv2 = $rdv2;

        return $this;
    }

    public function getMoyenRegional(): ?string
    {
        return $this->moyen_regional;
    }

    public function setMoyenRegional(?string $moyen_regional): self
    {
        $this->moyen_regional = $moyen_regional;

        return $this;
    }

    public function getMoyenNational(): ?string
    {
        return $this->moyen_national;
    }

    public function setMoyenNational(?string $moyen_national): self
    {
        $this->moyen_national = $moyen_national;

        return $this;
    }

    public function getOperateur(): ?User
    {
        return $this->operateur;
    }

    public function setOperateur(?User $operateur): self
    {
        $this->operateur = $operateur;

        return $this;
    }

    public function getChoix(): ?string
    {
        return $this->choix;
    }

    public function setChoix(?string $choix): self
    {
        $this->choix = $choix;

        return $this;
    }

    public function isStrange(): ?bool
    {
        return $this->strange;
    }

    public function setStrange(?bool $strange): self
    {
        $this->strange = $strange;

        return $this;
    }

    public function getStatutAppel(): ?float
    {
        return $this->statutAppel;
    }

    public function setStatutAppel(?float $statutAppel): self
    {
        $this->statutAppel = $statutAppel;

        return $this;
    }

    public function getStatutCondidat(): ?string
    {
        return $this->statutCondidat;
    }

    public function setStatutCondidat(?string $statutCondidat): self
    {
        $this->statutCondidat = $statutCondidat;

        return $this;
    }

    public function getStatutRdv(): ?string
    {
        return $this->statutRdv;
    }

    public function setStatutRdv(?string $statutRdv): self
    {
        $this->statutRdv = $statutRdv;

        return $this;
    }

    public function getRdv(): ?string
    {
        return $this->rdv;
    }

    public function setRdv(?string $rdv): self
    {
        $this->rdv = $rdv;

        return $this;
    }

    public function getFormationSouhaitee(): ?AcFormation
    {
        return $this->formationSouhaitee;
    }

    public function setFormationSouhaitee(?AcFormation $formationSouhaitee): self
    {
        $this->formationSouhaitee = $formationSouhaitee;

        return $this;
    }

    public function getCodeAssurance(): ?int
    {
        return $this->codeAssurance;
    }

    public function setCodeAssurance(?int $codeAssurance): self
    {
        $this->codeAssurance = $codeAssurance;

        return $this;
    }
}
