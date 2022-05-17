<?php

namespace App\Entity;

use App\Repository\ThematiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThematiqueRepository::class)]
class Thematique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $libelleThematique;

    #[ORM\OneToMany(mappedBy: 'thematique', targetEntity: ModuleThematique::class)]
    private $moduleThematiques;

    public function __construct()
    {
        $this->moduleThematiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleThematique(): ?string
    {
        return $this->libelleThematique;
    }

    public function setLibelleThematique(string $libelleThematique): self
    {
        $this->libelleThematique = $libelleThematique;

        return $this;
    }

    /**
     * @return Collection<int, ModuleThematique>
     */
    public function getModuleThematiques(): Collection
    {
        return $this->moduleThematiques;
    }

    public function addModuleThematique(ModuleThematique $moduleThematique): self
    {
        if (!$this->moduleThematiques->contains($moduleThematique)) {
            $this->moduleThematiques[] = $moduleThematique;
            $moduleThematique->setThematique($this);
        }

        return $this;
    }

    public function removeModuleThematique(ModuleThematique $moduleThematique): self
    {
        if ($this->moduleThematiques->removeElement($moduleThematique)) {
            // set the owning side to null (unless already changed)
            if ($moduleThematique->getThematique() === $this) {
                $moduleThematique->setThematique(null);
            }
        }

        return $this;
    }
}
