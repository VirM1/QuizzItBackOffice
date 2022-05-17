<?php

namespace App\Entity;

use App\Repository\ModuleThematiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleThematiqueRepository::class)]
class ModuleThematique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $libelleModuleThematique;

    #[ORM\ManyToOne(targetEntity: Thematique::class, inversedBy: 'moduleThematiques')]
    #[ORM\JoinColumn(nullable: false)]
    private $thematique;

    #[ORM\OneToMany(mappedBy: 'moduleThematique', targetEntity: Question::class)]
    private $questions;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: ReponseModuleThematique::class)]
    private $reponseModuleThematiques;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->reponseModuleThematiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleModuleThematique(): ?string
    {
        return $this->libelleModuleThematique;
    }

    public function setLibelleModuleThematique(string $libelleModuleThematique): self
    {
        $this->libelleModuleThematique = $libelleModuleThematique;

        return $this;
    }

    public function getThematique(): ?Thematique
    {
        return $this->thematique;
    }

    public function setThematique(?Thematique $thematique): self
    {
        $this->thematique = $thematique;

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
            $question->setModuleThematique($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getModuleThematique() === $this) {
                $question->setModuleThematique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReponseModuleThematique>
     */
    public function getReponseModuleThematiques(): Collection
    {
        return $this->reponseModuleThematiques;
    }

    public function addReponseModuleThematique(ReponseModuleThematique $reponseModuleThematique): self
    {
        if (!$this->reponseModuleThematiques->contains($reponseModuleThematique)) {
            $this->reponseModuleThematiques[] = $reponseModuleThematique;
            $reponseModuleThematique->setModule($this);
        }

        return $this;
    }

    public function removeReponseModuleThematique(ReponseModuleThematique $reponseModuleThematique): self
    {
        if ($this->reponseModuleThematiques->removeElement($reponseModuleThematique)) {
            // set the owning side to null (unless already changed)
            if ($reponseModuleThematique->getModule() === $this) {
                $reponseModuleThematique->setModule(null);
            }
        }

        return $this;
    }
}
