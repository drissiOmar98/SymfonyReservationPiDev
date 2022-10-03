<?php

namespace App\Entity;

use App\Repository\DetailTRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=DetailTRepository::class)
 */
class DetailT
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="la marque is required")

     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="the state is required")
     */
    private $etat;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="the price is required")
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateModification;

    /**
     * @ORM\OneToOne(targetEntity=Transport::class, cascade={"persist", "remove"},inversedBy="detailt")
     */
    private $transport;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(\DateTimeInterface $dateModification): self
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(?Transport $transport): self
    {
        $this->transport = $transport;

        return $this;
    }
}
