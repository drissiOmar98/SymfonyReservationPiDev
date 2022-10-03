<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="idH", columns={"idH"})})
 * @ORM\Entity
 */
class Panier
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPanier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpanier;

    /**
     * @var string|null
     *
     * @ORM\Column(name="idH", type="string", length=255, nullable=true)
     */
    private $idh;

    public function getIdpanier(): ?int
    {
        return $this->idpanier;
    }

    public function getIdh(): ?string
    {
        return $this->idh;
    }

    public function setIdh(?string $idh): self
    {
        $this->idh = $idh;

        return $this;
    }


}
