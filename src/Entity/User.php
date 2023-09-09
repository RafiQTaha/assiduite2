<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $username;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\ManyToMany(targetEntity: UsOperation::class, inversedBy: 'users')]
    private $operations;

    #[ORM\OneToMany(mappedBy: 'UserCreated', targetEntity: TBrdpaiement::class)]
    private $bordereaux;

    #[ORM\OneToMany(mappedBy: 'UserCreated', targetEntity: PrProgrammation::class)]
    private $programmations;

    #[ORM\OneToMany(mappedBy: 'UserCreated', targetEntity: PlEmptime::class)]
    private $emptimes;

    #[ORM\Column(type: 'boolean')]
    private $enable = false;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prenom;

    #[ORM\OneToMany(mappedBy: 'userCreated', targetEntity: HHonens::class)]
    private $honenss;

    #[ORM\OneToMany(mappedBy: 'userCreated', targetEntity: HAlbhon::class)]
    private $albhonss;

    #[ORM\OneToMany(mappedBy: 'usercreated', targetEntity: PEnsgrille::class)]
    private $ensgrilles;

    #[ORM\OneToMany(mappedBy: 'usercreated', targetEntity: PEnseignantExcept::class)]
    private $enseignantexcepts;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[ORM\OneToMany(mappedBy: 'operateur', targetEntity: TEtudiant::class)]
    private $tEtudiants;

    #[ORM\OneToMany(mappedBy: 'UserCreated', targetEntity: TReglement::class)]
    private $tReglements;

    #[ORM\OneToMany(mappedBy: 'userCreated', targetEntity: PAnonymatActuel::class)]
    private $pAnonymatActuels;

    #[ORM\OneToMany(mappedBy: 'userCreated', targetEntity: TInscriptionImpLog::class)]
    private $tInscriptionImpLogs;

    #[ORM\OneToMany(mappedBy: 'userCreated', targetEntity: TInscriptionImpControle::class)]
    private $tInscriptionImpControles;

    #[ORM\OneToMany(mappedBy: 'userCreated', targetEntity: TOperationdet::class)]
    private $tOperationDets;

    #[ORM\OneToMany(mappedBy: 'userDeleted', targetEntity: PlEmptime::class)]
    private $plEmptimes;

    #[ORM\OneToMany(mappedBy: 'userUpdated', targetEntity: TOperationdet::class)]
    private $tOperationdets;

    #[ORM\OneToMany(mappedBy: 'userCreated', targetEntity: InsSanctionner::class)]
    private $insSanctionners;

    #[ORM\OneToMany(mappedBy: 'userCreated', targetEntity: Pv::class)]
    private $pvs;

    #[ORM\OneToMany(mappedBy: 'userAnnulated', targetEntity: TBrdpaiement::class)]
    private $tBrdpaiements;

    #[ORM\OneToMany(mappedBy: 'userAnnulated', targetEntity: TPreinscription::class)]
    private $tPreinscriptions;

    #[ORM\OneToMany(mappedBy: 'userCreated', targetEntity: TPreinscription::class)]
    private $Preinscriptions;


    public function __construct()
    {
        $this->operations = new ArrayCollection();
        $this->bordereaux = new ArrayCollection();
        $this->programmations = new ArrayCollection();
        $this->emptimes = new ArrayCollection();
        $this->honenss = new ArrayCollection();
        $this->albhonss = new ArrayCollection();
        $this->ensgrilles = new ArrayCollection();
        $this->enseignantexcepts = new ArrayCollection();
        $this->tEtudiants = new ArrayCollection();
        $this->tReglements = new ArrayCollection();
        $this->pAnonymatActuels = new ArrayCollection();
        $this->tInscriptionImpLogs = new ArrayCollection();
        $this->tInscriptionImpControles = new ArrayCollection();
        $this->tOperationDets = new ArrayCollection();
        $this->plEmptimes = new ArrayCollection();
        $this->tOperationdets = new ArrayCollection();
        $this->insSanctionners = new ArrayCollection();
        $this->pvs = new ArrayCollection();
        $this->tBrdpaiements = new ArrayCollection();
        $this->tPreinscriptions = new ArrayCollection();
        $this->Preinscriptions = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|UsOperation[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(UsOperation $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations[] = $operation;
        }

        return $this;
    }

    public function removeOperation(UsOperation $operation): self
    {
        $this->operations->removeElement($operation);

        return $this;
    }

    /**
     * @return Collection|TBrdpaiement[]
     */
    public function getBordereaux(): Collection
    {
        return $this->bordereaux;
    }

    public function addBordereaux(TBrdpaiement $bordereaux): self
    {
        if (!$this->bordereaux->contains($bordereaux)) {
            $this->bordereaux[] = $bordereaux;
            $bordereaux->setUserCreated($this);
        }

        return $this;
    }

    public function removeBordereaux(TBrdpaiement $bordereaux): self
    {
        if ($this->bordereaux->removeElement($bordereaux)) {
            // set the owning side to null (unless already changed)
            if ($bordereaux->getUserCreated() === $this) {
                $bordereaux->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PrProgrammation[]
     */
    public function getProgrammations(): Collection
    {
        return $this->programmations;
    }

    public function addProgrammation(PrProgrammation $programmation): self
    {
        if (!$this->programmations->contains($programmation)) {
            $this->programmations[] = $programmation;
            $programmation->setUserCreated($this);
        }

        return $this;
    }

    public function removeProgrammation(PrProgrammation $programmation): self
    {
        if ($this->programmations->removeElement($programmation)) {
            // set the owning side to null (unless already changed)
            if ($programmation->getUserCreated() === $this) {
                $programmation->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PlEmptime[]
     */
    public function getEmptimes(): Collection
    {
        return $this->emptimes;
    }

    public function addEmptime(PlEmptime $emptime): self
    {
        if (!$this->emptimes->contains($emptime)) {
            $this->emptimes[] = $emptime;
            $emptime->setUserCreated($this);
        }

        return $this;
    }

    public function removeEmptime(PlEmptime $emptime): self
    {
        if ($this->emptimes->removeElement($emptime)) {
            // set the owning side to null (unless already changed)
            if ($emptime->getUserCreated() === $this) {
                $emptime->setUserCreated(null);
            }
        }

        return $this;
    }


    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

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
            $honenss->setUserCreated($this);
        }

        return $this;
    }

    public function removeHonenss(HHonens $honenss): self
    {
        if ($this->honenss->removeElement($honenss)) {
            // set the owning side to null (unless already changed)
            if ($honenss->getUserCreated() === $this) {
                $honenss->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HAlbhon>
     */
    public function getAlbhonss(): Collection
    {
        return $this->albhonss;
    }

    public function addAlbhonss(HAlbhon $albhonss): self
    {
        if (!$this->albhonss->contains($albhonss)) {
            $this->albhonss[] = $albhonss;
            $albhonss->setUserCreated($this);
        }

        return $this;
    }

    public function removeAlbhonss(HAlbhon $albhonss): self
    {
        if ($this->albhonss->removeElement($albhonss)) {
            // set the owning side to null (unless already changed)
            if ($albhonss->getUserCreated() === $this) {
                $albhonss->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PEnsgrille>
     */
    public function getEnsgrilles(): Collection
    {
        return $this->ensgrilles;
    }

    public function addEnsgrille(PEnsgrille $ensgrille): self
    {
        if (!$this->ensgrilles->contains($ensgrille)) {
            $this->ensgrilles[] = $ensgrille;
            $ensgrille->setUsercreated($this);
        }

        return $this;
    }

    public function removeEnsgrille(PEnsgrille $ensgrille): self
    {
        if ($this->ensgrilles->removeElement($ensgrille)) {
            // set the owning side to null (unless already changed)
            if ($ensgrille->getUsercreated() === $this) {
                $ensgrille->setUsercreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PEnseignantExcept>
     */
    public function getEnseignantexcepts(): Collection
    {
        return $this->enseignantexcepts;
    }

    public function addEnseignantexcept(PEnseignantExcept $enseignantexcept): self
    {
        if (!$this->enseignantexcepts->contains($enseignantexcept)) {
            $this->enseignantexcepts[] = $enseignantexcept;
            $enseignantexcept->setUsercreated($this);
        }

        return $this;
    }

    public function removeEnseignantexcept(PEnseignantExcept $enseignantexcept): self
    {
        if ($this->enseignantexcepts->removeElement($enseignantexcept)) {
            // set the owning side to null (unless already changed)
            if ($enseignantexcept->getUsercreated() === $this) {
                $enseignantexcept->setUsercreated(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, TEtudiant>
     */
    public function getTEtudiants(): Collection
    {
        return $this->tEtudiants;
    }

    public function addTEtudiant(TEtudiant $tEtudiant): self
    {
        if (!$this->tEtudiants->contains($tEtudiant)) {
            $this->tEtudiants[] = $tEtudiant;
            $tEtudiant->setOperateur($this);
        }

        return $this;
    }

    public function removeTEtudiant(TEtudiant $tEtudiant): self
    {
        if ($this->tEtudiants->removeElement($tEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($tEtudiant->getOperateur() === $this) {
                $tEtudiant->setOperateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TReglement>
     */
    public function getTReglements(): Collection
    {
        return $this->tReglements;
    }

    public function addTReglement(TReglement $tReglement): self
    {
        if (!$this->tReglements->contains($tReglement)) {
            $this->tReglements[] = $tReglement;
            $tReglement->setUserCreated($this);
        }

        return $this;
    }

    public function removeTReglement(TReglement $tReglement): self
    {
        if ($this->tReglements->removeElement($tReglement)) {
            // set the owning side to null (unless already changed)
            if ($tReglement->getUserCreated() === $this) {
                $tReglement->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PAnonymatActuel>
     */
    public function getPAnonymatActuels(): Collection
    {
        return $this->pAnonymatActuels;
    }

    public function addPAnonymatActuel(PAnonymatActuel $pAnonymatActuel): self
    {
        if (!$this->pAnonymatActuels->contains($pAnonymatActuel)) {
            $this->pAnonymatActuels[] = $pAnonymatActuel;
            $pAnonymatActuel->setUserCreated($this);
        }

        return $this;
    }

    public function removePAnonymatActuel(PAnonymatActuel $pAnonymatActuel): self
    {
        if ($this->pAnonymatActuels->removeElement($pAnonymatActuel)) {
            // set the owning side to null (unless already changed)
            if ($pAnonymatActuel->getUserCreated() === $this) {
                $pAnonymatActuel->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TInscriptionImpLog>
     */
    public function getTInscriptionImpLogs(): Collection
    {
        return $this->tInscriptionImpLogs;
    }

    public function addTInscriptionImpLog(TInscriptionImpLog $tInscriptionImpLog): self
    {
        if (!$this->tInscriptionImpLogs->contains($tInscriptionImpLog)) {
            $this->tInscriptionImpLogs[] = $tInscriptionImpLog;
            $tInscriptionImpLog->setUserCreated($this);
        }

        return $this;
    }

    public function removeTInscriptionImpLog(TInscriptionImpLog $tInscriptionImpLog): self
    {
        if ($this->tInscriptionImpLogs->removeElement($tInscriptionImpLog)) {
            // set the owning side to null (unless already changed)
            if ($tInscriptionImpLog->getUserCreated() === $this) {
                $tInscriptionImpLog->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TInscriptionImpControle>
     */
    public function getTInscriptionImpControles(): Collection
    {
        return $this->tInscriptionImpControles;
    }

    public function addTInscriptionImpControle(TInscriptionImpControle $tInscriptionImpControle): self
    {
        if (!$this->tInscriptionImpControles->contains($tInscriptionImpControle)) {
            $this->tInscriptionImpControles[] = $tInscriptionImpControle;
            $tInscriptionImpControle->setUserCreated($this);
        }

        return $this;
    }

    public function removeTInscriptionImpControle(TInscriptionImpControle $tInscriptionImpControle): self
    {
        if ($this->tInscriptionImpControles->removeElement($tInscriptionImpControle)) {
            // set the owning side to null (unless already changed)
            if ($tInscriptionImpControle->getUserCreated() === $this) {
                $tInscriptionImpControle->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TOperationDet>
     */
    public function getTOperationDets(): Collection
    {
        return $this->tOperationDets;
    }

    public function addTOperationDet(TOperationDet $tOperationDet): self
    {
        if (!$this->tOperationDets->contains($tOperationDet)) {
            $this->tOperationDets[] = $tOperationDet;
            $tOperationDet->setUserCreated($this);
        }

        return $this;
    }

    public function removeTOperationDet(TOperationDet $tOperationDet): self
    {
        if ($this->tOperationDets->removeElement($tOperationDet)) {
            // set the owning side to null (unless already changed)
            if ($tOperationDet->getUserCreated() === $this) {
                $tOperationDet->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlEmptime>
     */
    public function getPlEmptimes(): Collection
    {
        return $this->plEmptimes;
    }

    public function addPlEmptime(PlEmptime $plEmptime): self
    {
        if (!$this->plEmptimes->contains($plEmptime)) {
            $this->plEmptimes[] = $plEmptime;
            $plEmptime->setUserDeleted($this);
        }

        return $this;
    }

    public function removePlEmptime(PlEmptime $plEmptime): self
    {
        if ($this->plEmptimes->removeElement($plEmptime)) {
            // set the owning side to null (unless already changed)
            if ($plEmptime->getUserDeleted() === $this) {
                $plEmptime->setUserDeleted(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InsSanctionner>
     */
    public function getInsSanctionners(): Collection
    {
        return $this->insSanctionners;
    }

    public function addInsSanctionner(InsSanctionner $insSanctionner): self
    {
        if (!$this->insSanctionners->contains($insSanctionner)) {
            $this->insSanctionners[] = $insSanctionner;
            $insSanctionner->setUserCreated($this);
        }

        return $this;
    }

    public function removeInsSanctionner(InsSanctionner $insSanctionner): self
    {
        if ($this->insSanctionners->removeElement($insSanctionner)) {
            // set the owning side to null (unless already changed)
            if ($insSanctionner->getUserCreated() === $this) {
                $insSanctionner->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pv>
     */
    public function getPvs(): Collection
    {
        return $this->pvs;
    }

    public function addPv(Pv $pv): self
    {
        if (!$this->pvs->contains($pv)) {
            $this->pvs[] = $pv;
            $pv->setUserCreated($this);
        }

        return $this;
    }

    public function removePv(Pv $pv): self
    {
        if ($this->pvs->removeElement($pv)) {
            // set the owning side to null (unless already changed)
            if ($pv->getUserCreated() === $this) {
                $pv->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TBrdpaiement>
     */
    public function getTBrdpaiements(): Collection
    {
        return $this->tBrdpaiements;
    }

    public function addTBrdpaiement(TBrdpaiement $tBrdpaiement): self
    {
        if (!$this->tBrdpaiements->contains($tBrdpaiement)) {
            $this->tBrdpaiements[] = $tBrdpaiement;
            $tBrdpaiement->setUserAnnulated($this);
        }

        return $this;
    }

    public function removeTBrdpaiement(TBrdpaiement $tBrdpaiement): self
    {
        if ($this->tBrdpaiements->removeElement($tBrdpaiement)) {
            // set the owning side to null (unless already changed)
            if ($tBrdpaiement->getUserAnnulated() === $this) {
                $tBrdpaiement->setUserAnnulated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TPreinscription>
     */
    public function getTPreinscriptions(): Collection
    {
        return $this->tPreinscriptions;
    }

    public function addTPreinscription(TPreinscription $tPreinscription): self
    {
        if (!$this->tPreinscriptions->contains($tPreinscription)) {
            $this->tPreinscriptions[] = $tPreinscription;
            $tPreinscription->setUserAnnulated($this);
        }

        return $this;
    }

    public function removeTPreinscription(TPreinscription $tPreinscription): self
    {
        if ($this->tPreinscriptions->removeElement($tPreinscription)) {
            // set the owning side to null (unless already changed)
            if ($tPreinscription->getUserAnnulated() === $this) {
                $tPreinscription->setUserAnnulated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TPreinscription>
     */
    public function getPreinscriptions(): Collection
    {
        return $this->Preinscriptions;
    }

    public function addPreinscription(TPreinscription $preinscription): self
    {
        if (!$this->Preinscriptions->contains($preinscription)) {
            $this->Preinscriptions[] = $preinscription;
            $preinscription->setUserCreated($this);
        }

        return $this;
    }

    public function removePreinscription(TPreinscription $preinscription): self
    {
        if ($this->Preinscriptions->removeElement($preinscription)) {
            // set the owning side to null (unless already changed)
            if ($preinscription->getUserCreated() === $this) {
                $preinscription->setUserCreated(null);
            }
        }

        return $this;
    }

}