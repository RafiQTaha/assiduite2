<?php

namespace App\Entity;

use App\Repository\TAdmissionDocumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TAdmissionDocumentRepository::class)]
class TAdmissionDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code;

    #[ORM\ManyToOne(targetEntity: TPreinscription::class, inversedBy: 'admissionDocuments')]
    private $preinscription;

    #[ORM\ManyToOne(targetEntity: PDocument::class, inversedBy: 'admissionDocuments')]
    private $document;

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

    public function getPreinscription(): ?TPreinscription
    {
        return $this->preinscription;
    }

    public function setPreinscription(?TPreinscription $preinscription): self
    {
        $this->preinscription = $preinscription;

        return $this;
    }

    public function getDocument(): ?PDocument
    {
        return $this->document;
    }

    public function setDocument(?PDocument $document): self
    {
        $this->document = $document;

        return $this;
    }
}
