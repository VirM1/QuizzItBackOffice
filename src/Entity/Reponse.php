<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $titreReponse;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false,onDelete: "CASCADE")]
    private $question;

    #[ORM\ManyToMany(targetEntity: ReponseModuleThematique::class, mappedBy: 'reponses')]
    private $reponseModuleThematiques;

    public function __construct()
    {
        $this->reponseModuleThematiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreReponse(): ?string
    {
        return $this->titreReponse;
    }

    public function setTitreReponse(string $titreReponse): self
    {
        $this->titreReponse = $titreReponse;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function __toString(): string {
        return $this->titreReponse;
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
            $reponseModuleThematique->addReponse($this);
        }

        return $this;
    }

    public function removeReponseModuleThematique(ReponseModuleThematique $reponseModuleThematique): self
    {
        if ($this->reponseModuleThematiques->removeElement($reponseModuleThematique)) {
            $reponseModuleThematique->removeReponse($this);
        }

        return $this;
    }
}
