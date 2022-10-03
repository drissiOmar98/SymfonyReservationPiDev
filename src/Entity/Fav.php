<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fav
 *
 * @ORM\Table(name="fav", indexes={@ORM\Index(name="idoffre", columns={"idoffre"})})
 * @ORM\Entity
 */
class Fav
{
    /**
     * @var string
     *
     * @ORM\Column(name="idFav", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idfav;

    /**
     * @var string
     *
     * @ORM\Column(name="idoffre", type="string", length=100, nullable=false)
     */
    private $idoffre;

    /**
     * @var int
     *
     * @ORM\Column(name="VL", type="integer", nullable=false)
     */
    private $vl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datelike", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datelike = 'CURRENT_TIMESTAMP';

    public function getIdfav(): ?string
    {
        return $this->idfav;
    }

    public function getIdoffre(): ?string
    {
        return $this->idoffre;
    }

    public function setIdoffre(string $idoffre): self
    {
        $this->idoffre = $idoffre;

        return $this;
    }

    public function getVl(): ?int
    {
        return $this->vl;
    }

    public function setVl(int $vl): self
    {
        $this->vl = $vl;

        return $this;
    }

    public function getDatelike(): ?\DateTimeInterface
    {
        return $this->datelike;
    }

    public function setDatelike(\DateTimeInterface $datelike): self
    {
        $this->datelike = $datelike;

        return $this;
    }


}
