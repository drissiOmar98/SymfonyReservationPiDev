<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vol
 *
 * @ORM\Table(name="vol", uniqueConstraints={@ORM\UniqueConstraint(name="numv", columns={"id"})})
 * @ORM\Entity
 */
class Vol
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     *  @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="apartir", type="string", length=255, nullable=false)
     *  @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     */
    private $apartir;

    /**
     * @var string
     *
     * @ORM\Column(name="vers", type="string", length=255, nullable=false)
     *  @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     */
    private $vers;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dated", type="date", nullable=false)
     */
    private $dated;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="chauffeur", type="string", length=255, nullable=false)
     *  @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     */
    private $chauffeur;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

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

    public function getApartir(): ?string
    {
        return $this->apartir;
    }

    public function setApartir(string $apartir): self
    {
        $this->apartir = $apartir;

        return $this;
    }

    public function getVers(): ?string
    {
        return $this->vers;
    }

    public function setVers(string $vers): self
    {
        $this->vers = $vers;

        return $this;
    }

    public function getDated(): ?\DateTimeInterface
    {
        return $this->dated;
    }

    public function setDated(\DateTimeInterface $dated): self
    {
        $this->dated = $dated;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getChauffeur(): ?string
    {
        return $this->chauffeur;
    }

    public function setChauffeur(string $chauffeur): self
    {
        $this->chauffeur = $chauffeur;

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


}
