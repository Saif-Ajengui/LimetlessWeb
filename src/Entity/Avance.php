<?php

namespace App\Entity;

use App\Repository\AvanceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AvanceRepository::class)
 */
class Avance
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAvance", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idavance;

    /**
     * @var string
     *
     * @ORM\Column(name="motivation", type="string", length=50, nullable=false)
     * @Assert\NotBlank
     */
    private $motivation;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=30, nullable=false)
     * @Assert\NotBlank
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=30, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 4,
     *      max = 10,
     *      minMessage = "Your prize name must be at least 4 characters long",
     *      maxMessage = "Your prize name cannot be longer than 10 characters"
     * )
     */
    private $prix;



    public function getIdavance(): ?int
    {
        return $this->idavance;
    }

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): self
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
