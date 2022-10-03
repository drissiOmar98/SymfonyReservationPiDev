<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Transport
 *
 * @ORM\Table(name="transport", indexes={@ORM\Index(name="reference", columns={"id"})})
 * @ORM\Entity
 */
class Transport
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * @Assert\Length(
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
     * @ORM\Column(name="availability", type="string", length=255, nullable=false)
     *   @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     */
    private $availability;

    /**
     * @var string
     *
     * @ORM\Column(name="driver", type="string", length=255, nullable=false)
     *  @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     */
    private $driver;

    /**
     * @return mixed
     */
    public function getDetailt()
    {
        return $this->detailt;
    }

    /**
     * @param mixed $detailt
     */
    public function setDetailt($detailt): void
    {
        $this->detailt = $detailt;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     *  @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     */
    private $path;

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
     *
     *
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
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @ORM\OneToOne(targetEntity=DetailT::class, cascade={"persist", "remove"},mappedBy="transport")
     *
     */
    private $detailt;

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

    public function getAvailability(): ?string
    {
        return $this->availability;
    }

    public function setAvailability(string $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getDriver(): ?string
    {
        return $this->driver;
    }

    public function setDriver(string $driver): self
    {
        $this->driver = $driver;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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
