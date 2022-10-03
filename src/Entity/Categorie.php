<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcategorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategorie;

    /**
     * @var string
     * @Assert\NotBlank(message= " ce champs est obligatoire ")
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var \Events
     * @ORM\ManyToOne(targetEntity="Events")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    public function getIdcategorie(): ?int
    {
        return $this->idcategorie;
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

    public function getId(): ?Events
    {
        return $this->id;
    }

    public function setId(?Events $id): self
    {
        $this->id = $id;

        return $this;
    }



}
