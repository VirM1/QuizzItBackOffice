<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $titreQuestion;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $noteQuestion;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $aideQuestion;

    #[ORM\ManyToOne(targetEntity: ModuleThematique::class, inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private $moduleThematique;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Reponse::class)]
    private $reponses;

    #[ORM\OneToOne(targetEntity: Reponse::class, cascade: ['persist', 'remove'])]
    private $bonneReponse;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreQuestion(): ?string
    {
        return $this->titreQuestion;
    }

    public function setTitreQuestion(string $titreQuestion): self
    {
        $this->titreQuestion = $titreQuestion;

        return $this;
    }

    public function getNoteQuestion(): ?string
    {
        return $this->noteQuestion;
    }

    public function setNoteQuestion(?string $noteQuestion): self
    {
        $this->noteQuestion = $noteQuestion;

        return $this;
    }

    public function getAideQuestion(): ?string
    {
        return $this->aideQuestion;
    }

    public function setAideQuestion(?string $aideQuestion): self
    {
        $this->aideQuestion = $aideQuestion;

        return $this;
    }

    public function getModuleThematique(): ?ModuleThematique
    {
        return $this->moduleThematique;
    }

    public function setModuleThematique(?ModuleThematique $moduleThematique): self
    {
        $this->moduleThematique = $moduleThematique;

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setQuestion($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestion() === $this) {
                $reponse->setQuestion(null);
            }
        }

        return $this;
    }

    public function getBonneReponse(): ?Reponse
    {
        return $this->bonneReponse;
    }

    public function setBonneReponse(?Reponse $bonneReponse): self
    {
        $this->bonneReponse = $bonneReponse;

        return $this;
    }

    public function __toString(): string
    {
        return $this->titreQuestion;
    }
}
