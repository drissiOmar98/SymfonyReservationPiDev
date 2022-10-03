<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * Events
 *
 * @ORM\Table(name="events", indexes={@ORM\Index(name="idevent", columns={"id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Events
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
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="period", type="integer", nullable=false)
     *
     */
    private $period;

    /**
     * @var string
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=false)
     */
    private $location;

    /**
     * @var string
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    private $path;

    /**
     * @ORM\OneToMany(targetEntity=PostL::class, mappedBy="post")
     */
    private $likes;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     *
     * @ORM\Column(name="available", type="string", length=255, nullable=false)
     */
    private $available;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @Vich\UploadableField(mapping="salles_images", fileNameProperty="path")
     * @var File
     */
    private $imageFile;

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

    public function getPeriod(): ?int
    {
        return $this->period;
    }

    public function setPeriod(int $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath( ?string $path ): self
    {
        $this->path = $path;

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

    public function getAvailable(): ?string
    {
        return $this->available;
    }

    public function setAvailable(string $available): self
    {
        $this->available = $available;

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

    /**
     * @return Collection|PostL[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(PostL $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setPost($like);
        }

        return $this;
    }
    public function setImageFile( $path = null)
    {
        $this->imageFile = $path;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($path) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }


}
