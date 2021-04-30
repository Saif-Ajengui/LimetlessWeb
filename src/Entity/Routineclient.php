<?php

namespace App\Entity;

use App\Repository\RoutineclientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Routineclient
 *
 * @ORM\Table(name="routineclient")
 * @ORM\Entity
 */
class Routineclient
{
    /**
     * @var int
     *
     * @ORM\Column(name="idtache", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtache;

    /**
     * @var string
     *
     * @ORM\Column(name="nomCoach", type="string", length=30, nullable=false)
     * @Assert\NotBlank
     */
    private $nomcoach;

    /**
     * @var string
     *
     * @ORM\Column(name="nomClient", type="string", length=30, nullable=false)
     * @Assert\NotBlank
     */
    private $nomclient;

    /**
     * @var string
     *
     * @ORM\Column(name="nomTache", type="string", length=30, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 4,
     *      max = 10,
     *      minMessage = "Your tache name must be at least 4 characters long",
     *      maxMessage = "Your tache name cannot be longer than 10 characters"
     * )
     */
    private $nomtache;

    /**
     * @var string
     *
     * @ORM\Column(name="avancement", type="string", length=50, nullable=false)
     * @Assert\NotBlank
     */
    private $avancement;

    /**
     * @var string
     *
     * @ORM\Column(name="duree", type="string", length=5, nullable=false)
     * @Assert\NotBlank
     * @Assert\Range(
     *      min = 1,
     *      max=10,
     *      minMessage = "Duree non valide ",
     *      maxMessage = "Duree Dépassée ",
     * )
     */
    private $duree;


    public function getIdtache(): ?int
    {
        return $this->idtache;
    }

    public function getNomcoach(): ?string
    {
        return $this->nomcoach;
    }

    public function setNomCoach(string $nomcoach): self
    {
        $this->nomcoach = $nomcoach;

        return $this;
    }

    public function getNomclient(): ?string
    {
        return $this->nomclient;
    }

    public function setNomclient(string $nomclient): self
    {
        $this->nomclient = $nomclient;

        return $this;
    }

    public function getNomtache(): ?string
    {
        return $this->nomtache;
    }

    public function setNomtache(string $nomtache): self
    {
        $this->nomtache = $nomtache;

        return $this;
    }

    public function getAvancement(): ?string
    {
        return $this->avancement;
    }

    public function setAvancement(string $avancement): self
    {
        $this->avancement = $avancement;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }



}
