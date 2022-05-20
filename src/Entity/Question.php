<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Serializer\Groups({"serialize_quizz_detail"})
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $titreQuestion;

    /**
     * @Serializer\Groups({"serialize_quizz_detail"})
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $noteQuestion;

    /**
     * @Serializer\Groups({"serialize_quizz_detail"})
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $aideQuestion;

    #[ORM\ManyToOne(targetEntity: ModuleThematique::class, inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private $moduleThematique;

    /**
     * @Serializer\Groups({"serialize_quizz_detail"})
     */
    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Reponse::class,orphanRemoval: true,cascade: ["remove","persist"])]
    private $reponses;

    #[ORM\OneToOne(targetEntity: Reponse::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(onDelete: "SET NULL")]
    private $bonneReponse;


    #[ORM\ManyToMany(targetEntity: ReponseModuleThematique::class, inversedBy: 'questions')]
    #[ORM\JoinTable(name:"questions_reponse_module_thematique")]
    #[ORM\InverseJoinColumn(name: "date_creation", referencedColumnName: "date_creation")]
    #[ORM\InverseJoinColumn(name: "module_id", referencedColumnName: "module_id")]
    #[ORM\InverseJoinColumn(name: "utilisateur_id", referencedColumnName: "utilisateur_id")]
    private $reponseModuleThematique;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
        $this->reponseModuleThematique = new ArrayCollection();
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
        if($bonneReponse instanceof Reponse){
            if($bonneReponse->getQuestion() !== $this){
                $this->bonneReponse = null;
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReponseModuleThematique>
     */
    public function getReponseModuleThematique(): Collection
    {
        return $this->reponseModuleThematique;
    }

    public function addReponseModuleThematique(ReponseModuleThematique $reponseModuleThematique): self
    {
        if (!$this->reponseModuleThematique->contains($reponseModuleThematique)) {
            $this->reponseModuleThematique[] = $reponseModuleThematique;
        }

        return $this;
    }

    public function removeReponseModuleThematique(ReponseModuleThematique $reponseModuleThematique): self
    {
        $this->reponseModuleThematique->removeElement($reponseModuleThematique);

        return $this;
    }

    public function __toString(): string
    {
        return $this->titreQuestion;
    }
}
