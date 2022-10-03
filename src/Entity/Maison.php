<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Maison
 *
 * @ORM\Table(name="maison")
 *@ORM\Entity(repositoryClass="App\Repository\MaisonRepository")
 */
class Maison
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string

     * @ORM\Column(name="Lieu", type="string", length=255, nullable=false)

     * @Assert\Length(
     *      min = 1,
     *      max = 100,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     */
    private $lieu;

    /**

     * @Assert\Length(
     *      min = 1,
     *      max = 100,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     * @var string
     *
     * @ORM\Column(name="Hebergement", type="string", length=255, nullable=false)
     */
    private $hebergement;

    /**

     * @Assert\Length(
     *      min = 1,
     *      max = 100,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     * @var int
     *
     * @ORM\Column(name="Prix", type="integer", nullable=false)
     */
    private $prix;

    /**

     * @Assert\Length(
     *      min = 1,
     *      max = 100,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255, nullable=false)
     */
    private $nom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getHebergement(): ?string
    {
        return $this->hebergement;
    }

    public function setHebergement(string $hebergement): self
    {
        $this->hebergement = $hebergement;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
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


}
