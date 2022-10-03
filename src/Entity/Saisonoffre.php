<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Saisonoffre
 *
 * @ORM\Table(name="saisonoffre", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Saisonoffre
{
    /**
     * @var int
     *
     * @ORM\Column(name="idsaison", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsaison;

    /**
     * @var string
     *
     * @ORM\Column(name="titresaison", type="string", length=255, nullable=false)
     */
    private $titresaison;

    /**
     * @var \Offre
     *
     * @ORM\ManyToOne(targetEntity="Offre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    public function getIdsaison(): ?int
    {
        return $this->idsaison;
    }

    public function getTitresaison(): ?string
    {
        return $this->titresaison;
    }

    public function setTitresaison(string $titresaison): self
    {
        $this->titresaison = $titresaison;

        return $this;
    }

    public function getId(): ?Offre
    {
        return $this->id;
    }

    public function setId(?Offre $id): self
    {
        $this->id = $id;

        return $this;
    }


}
