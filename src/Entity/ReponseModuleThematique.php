<?php

namespace App\Entity;

use App\Repository\ReponseModuleThematiqueRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseModuleThematiqueRepository::class)]
class ReponseModuleThematique
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: ModuleThematique::class, inversedBy: 'reponseModuleThematiques')]
    #[ORM\JoinColumn(nullable: false,referencedColumnName: "id")]
    private $module;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'reponseModuleThematiques')]
    #[ORM\JoinColumn(nullable: false,referencedColumnName: "id")]
    private $utilisateur;

    #[ORM\Id]
    #[ORM\Column(type: 'datetime')]
    private $dateCreation;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateValidation;

    #[ORM\ManyToMany(targetEntity: Question::class, mappedBy: 'reponseModuleThematique')]
    private $questions;

    #[ORM\ManyToMany(targetEntity: Reponse::class, inversedBy: 'reponseModuleThematiques')]
    #[ORM\JoinTable(name:"reponses_reponse_module_thematique")]
    #[ORM\JoinColumn(name: "date_creation", referencedColumnName: "date_creation")]
    #[ORM\JoinColumn(name: "module_id", referencedColumnName: "module_id")]
    #[ORM\JoinColumn(name: "utilisateur_id", referencedColumnName: "utilisateur_id")]
    private $reponses;


    public function __construct()
    {
        $this->dateCreation = new DateTime();
        $this->questions = new ArrayCollection();
        $this->reponses = new ArrayCollection();
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

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->addReponseModuleThematique($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            $question->removeReponseModuleThematique($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponses(Reponse $reponses): self
    {
        if (!$this->reponses->contains($reponses)) {
            $this->reponses[] = $reponses;
        }

        return $this;
    }

    public function removeReponses(Reponse $reponses): self
    {
        $this->reponses->removeElement($reponses);

        return $this;
    }
}
