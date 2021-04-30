<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_event", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_event;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     * @assert\Length(
     *     min=1,
     *     max=50,
     *     minMessage = "Ce champ doit comporter au moin un mot",
     *     maxMessage = "Champ ne supporte pas cette longueur"
     *     )
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=80, nullable=false)
     * @assert\Length(
     *     min=1,
     *     max=50,
     *     minMessage = "Ce champ doit comporter au moin un mot",
     *     maxMessage = "Champ ne supporte pas cette longueur"
     *     )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     * @assert\Length(
     *     min=1,
     *     max=50,
     *     minMessage = "Ce champ doit comporter au moin un mot",
     *     maxMessage = "Champ ne supporte pas cette longueur"
     *     )
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="date_deb", type="date", length=100, nullable=false)
     */
    private $dateDeb;

    /**
     * @var string
     *
     * @ORM\Column(name="date_fin", type="date", length=100, nullable=false)
     */
    private $dateFin;

    /**
     * @var int
     *
     * @ORM\Column(name="nbParticipant", type="integer", nullable=true)
     */
    private $nbParticipant;


    /**
     * @var int
     *
     * @ORM\Column(name="nbMaxParticipant", type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(
     *     value = 0,
     *     message = "La nombre doit être superieure ou égale à 0"
     * )

     */
    private $nbMaxParticipant;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lng;

    /**
     * Evenement constructor.
     */
    public function __construct()
    {

    }


    public function getId_event(): ?int
    {
        return $this->id_event;
    }

    /**
     * @param int $id_event
     */
    public function setId_event(int $id_event): void
    {
        $this->id_event = $id_event;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }



    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }




    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateDeb(): ?\DateTimeInterface
    {
        return $this->dateDeb;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTimeInterface $dateDeb
     */
    public function setDateDeb(\DateTimeInterface $dateDeb): void
    {
        $this->dateDeb = $dateDeb;
    }

    /**
     * @param \DateTimeInterface $dateFin
     */
    public function setDateFin(\DateTimeInterface $dateFin): void
    {
        $this->dateFin = $dateFin;
    }






    /**
     * @return int
     */
    public function getNbParticipant(): int
    {
        return $this->nbParticipant;
    }

    /**
     * @return int
     */
    public function getNbMaxParticipant(): int
    {
        return $this->nbMaxParticipant;
    }


    /**
     * @param int $nbParticipant
     */
    public function setNbParticipant(int $nbParticipant): void
    {
        $this->nbParticipant = $nbParticipant;
    }

    /**
     * @param int $nbMaxParticipant
     */
    public function setNbMaxParticipant(int $nbMaxParticipant): void
    {
        $this->nbMaxParticipant = $nbMaxParticipant;
    }

    public function ajoutNbParticip(): void
    {
        $this->nbParticipant = $this->nbParticipant+1;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }


}
