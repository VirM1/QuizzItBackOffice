<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{

    public const AVAILABLE_ROLES = array("user.role.admin"=>self::ROLE_ADMIN,"user.role.user"=>self::ROLE_USER);

    public const ROLE_SUPER_ADMIN = "ROLE_SUPER_ADMIN";
    public const ROLE_ADMIN = "ROLE_ADMIN";
    public const ROLE_USER = "ROLE_USER";

    /**
     * @Serializer\Groups({"serialize_quizz_detail"})
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Serializer\Groups({"serialize_user_detail", "serialize_quizz_detail"})
     */
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $tokenUtilisateur;

    /**
     * @Serializer\Groups({"serialize_user_detail", "serialize_quizz_detail"})
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $nomUtilisateur;


    /**
     * @Serializer\Groups({"serialize_user_detail", "serialize_quizz_detail"})
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $prenomUtilisateur;


    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: ReponseModuleThematique::class)]
    private $reponseModuleThematiques;

    public function __construct()
    {
        $this->reponseModuleThematiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getToken(): ?string
    {
        return $this->tokenUtilisateur;
    }

    public function setToken(?string $tokenUtilisateur): self
    {
        $this->tokenUtilisateur = $tokenUtilisateur;

        return $this;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): self
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenomUtilisateur;
    }

    public function setPrenomUtilisateur(string $prenomUtilisateur): self
    {
        $this->prenomUtilisateur = $prenomUtilisateur;

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
            $reponseModuleThematique->setUtilisateur($this);
        }

        return $this;
    }

    public function removeReponseModuleThematique(ReponseModuleThematique $reponseModuleThematique): self
    {
        if ($this->reponseModuleThematiques->removeElement($reponseModuleThematique)) {
            // set the owning side to null (unless already changed)
            if ($reponseModuleThematique->getUtilisateur() === $this) {
                $reponseModuleThematique->setUtilisateur(null);
            }
        }

        return $this;
    }
}
