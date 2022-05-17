<?php

namespace App\Entity;

use App\Repository\ReponseModuleThematiqueRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseModuleThematiqueRepository::class)]
class ReponseModuleThematique
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: ModuleThematique::class, inversedBy: 'reponseModuleThematiques')]
    #[ORM\JoinColumn(nullable: false)]
    private $module;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'reponseModuleThematiques')]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;

    #[ORM\Id]
    #[ORM\Column(type: 'datetime')]
    private $dateCreation;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateValidation;


    public function __construct()
    {
        $this->dateCreation = new DateTime();
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }


    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->dateValidation;
    }

    public function setDateValidation(?\DateTimeInterface $dateValidation): self
    {
        $this->dateValidation = $dateValidation;

        return $this;
    }

    public function getModule(): ?ModuleThematique
    {
        return $this->module;
    }

    public function setModule(?ModuleThematique $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
