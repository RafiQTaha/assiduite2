<?php

namespace App\Entity;
    
use App\Repository\TReglementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TReglementRepository::class)]
class TReglement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\ManyToOne(targetEntity: TOperationcab::class, inversedBy: 'Reglements')]
    private $operation;

    #[ORM\Column(type: 'float', nullable: true)]
    private $montant;

    #[ORM\Column(type: 'smallint', nullable: true)]
    private $remise;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date_reglement;

    #[ORM\ManyToOne(targetEntity: XBanque::class, inversedBy: 'Reglements')]
    private $banque;

    #[ORM\ManyToOne(targetEntity: XModalites::class, inversedBy: 'Reglements')]
    private $paiement;
    
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $reference;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created;

    #[ORM\ManyToOne(targetEntity: TBrdpaiement::class, inversedBy: 'Reglements')]
    private $bordereau;

    #[ORM\Column(type: 'float', nullable: true)]
    private $impayer;

    #[ORM\Column(type: 'float')]
    private $payant;

    #[ORM\Column(type: 'float', nullable: true)]
    private $annuler = 0;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $annuler_motif;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tReglements')]
    private $UserCreated;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tReglements')]
    private $UserUpdated;

    #[ORM\Column(type: 'float', nullable: true)]
    private $m_provisoir;

    #[ORM\Column(type: 'float', nullable: true)]
    private $m_devis;

    #[ORM\Column(type: 'float', nullable: true)]
    private $synFlag = 0;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ice;

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

    public function getOperation(): ?TOperationcab
    {
        return $this->operation;
    }

    public function setOperation(?TOperationcab $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getRemise(): ?int
    {
        return $this->remise;
    }

    public function setRemise(?int $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getDateReglement(): ?\DateTimeInterface
    {
        return $this->date_reglement;
    }

    public function setDateReglement(?\DateTimeInterface $date_reglement): self
    {
        $this->date_reglement = $date_reglement;

        return $this;
    }

    public function getBanque(): ?XBanque
    {
        return $this->banque;
    }

    public function setBanque(?XBanque $banque): self
    {
        $this->banque = $banque;

        return $this;
    }

    public function getPaiement(): ?XModalites
    {
        return $this->paiement;
    }

    public function setPaiement(?XModalites $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

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

    public function getBordereau(): ?TBrdpaiement
    {
        return $this->bordereau;
    }

    public function setBordereau(?TBrdpaiement $bordereau): self
    {
        $this->bordereau = $bordereau;

        return $this;
    }

    public function getImpayer(): ?float
    {
        return $this->impayer;
    }

    public function setImpayer(?float $impayer): self
    {
        $this->impayer = $impayer;

        return $this;
    }

    public function getPayant(): ?float
    {
        return $this->payant;
    }

    public function setPayant(float $payant): self
    {
        $this->payant = $payant;

        return $this;
    }

    public function getAnnuler(): ?float
    {
        return $this->annuler;
    }

    public function setAnnuler(?float $annuler): self
    {
        $this->annuler = $annuler;

        return $this;
    }

    public function getAnnulerMotif(): ?string
    {
        return $this->annuler_motif;
    }

    public function setAnnulerMotif(?string $annuler_motif): self
    {
        $this->annuler_motif = $annuler_motif;

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

    public function getUserCreated(): ?User
    {
        return $this->UserCreated;
    }

    public function setUserCreated(?User $UserCreated): self
    {
        $this->UserCreated = $UserCreated;

        return $this;
    }

    public function getUserUpdated(): ?User
    {
        return $this->UserUpdated;
    }

    public function setUserUpdated(?User $UserUpdated): self
    {
        $this->UserUpdated = $UserUpdated;

        return $this;
    }

    public function getMProvisoir(): ?float
    {
        return $this->m_provisoir;
    }

    public function setMProvisoir(?float $m_provisoir): self
    {
        $this->m_provisoir = $m_provisoir;

        return $this;
    }

    public function getMDevis(): ?float
    {
        return $this->m_devis;
    }

    public function setMDevis(?float $m_devis): self
    {
        $this->m_devis = $m_devis;

        return $this;
    }

    public function getSynFlag(): ?float
    {
        return $this->synFlag;
    }

    public function setSynFlag(?float $synFlag): self
    {
        $this->synFlag = $synFlag;

        return $this;
    }

    public function getIce(): ?string
    {
        return $this->ice;
    }

    public function setIce(?string $ice): self
    {
        $this->ice = $ice;

        return $this;
    }
}
