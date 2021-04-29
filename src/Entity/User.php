<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     *
     */
    //@Assert\NotBlank(message="nom is required")
    private $nom;

    /**
     * @ORM\Column(name="prenom", type="string", length=30, nullable=false)
     *
     */
    //@Assert\NotBlank(message="prenom is required")
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(name="login", type="string", length=20, nullable=false)

     */
    private $login;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(name="image", type="string", length=10000, nullable=false)

     */
    private $image;

    /**
     * @ORM\Column(name="sexe", type="string", length=1, nullable=false)

     */
    private $sexe;

    /**
     * @ORM\Column(name="Date_naiss", type="date")

     */
    private $dateNaiss;

    /**
     * @ORM\Column(name="type", type="string", length=20, nullable=false)

     */
    private $type;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(name="isvalider", type="boolean", nullable=false)
     */
    private $isvalider;

    /**
     * @ORM\Column(name="activite", type="string", length=100, nullable=true)

     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reset_token;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->nom;
    }

    public function setUsername(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }


    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->dateNaiss;
    }


    public function setDateNaiss( \DateTimeInterface $dateNaiss): void
    {
        $this->dateNaiss = $dateNaiss;
    }



    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIsvalider(): ?bool
    {
        return $this->isvalider;
    }

    public function setIsvalider(bool $isvalider): self
    {
        $this->isvalider = $isvalider;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }


    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
        //return ['ROLE_USER'];
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return mixed
     */
    public function getResetToken()
    {
        return $this->reset_token;
    }

    /**
     * @param mixed $reset_token
     */
    public function setResetToken($reset_token): void
    {
        $this->reset_token = $reset_token;
    }
}
