<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resevation
 *
 * @ORM\Table(name="resevation", indexes={@ORM\Index(name="idRes", columns={"idR"}), @ORM\Index(name="idHo", columns={"idHo"}), @ORM\Index(name="referance", columns={"referance"}), @ORM\Index(name="numv", columns={"numv"})})
 * @ORM\Entity
 */
class Resevation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idr;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=200, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="pos_map", type="string", length=255, nullable=false)
     */
    private $posMap;

    /**
     * @var int
     *
     * @ORM\Column(name="prixT", type="integer", nullable=false)
     */
    private $prixt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datereservation", type="datetime", nullable=false)
     */
    private $datereservation;

    /**
     * @var \Transport
     *
     * @ORM\ManyToOne(targetEntity="Transport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="referance", referencedColumnName="id")
     * })
     */
    private $referance;

    /**
     * @var \Vol
     *
     * @ORM\ManyToOne(targetEntity="Vol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="numv", referencedColumnName="id")
     * })
     */
    private $numv;

    /**
     * @var \Hotel
     *
     * @ORM\ManyToOne(targetEntity="Hotel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idHo", referencedColumnName="id")
     * })
     */
    private $idho;

    public function getIdr(): ?int
    {
        return $this->idr;
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

    public function getPosMap(): ?string
    {
        return $this->posMap;
    }

    public function setPosMap(string $posMap): self
    {
        $this->posMap = $posMap;

        return $this;
    }

    public function getPrixt(): ?int
    {
        return $this->prixt;
    }

    public function setPrixt(int $prixt): self
    {
        $this->prixt = $prixt;

        return $this;
    }

    public function getDatereservation(): ?\DateTimeInterface
    {
        return $this->datereservation;
    }

    public function setDatereservation(\DateTimeInterface $datereservation): self
    {
        $this->datereservation = $datereservation;

        return $this;
    }

    public function getReferance(): ?Transport
    {
        return $this->referance;
    }

    public function setReferance(?Transport $referance): self
    {
        $this->referance = $referance;

        return $this;
    }

    public function getNumv(): ?Vol
    {
        return $this->numv;
    }

    public function setNumv(?Vol $numv): self
    {
        $this->numv = $numv;

        return $this;
    }

    public function getIdho(): ?Hotel
    {
        return $this->idho;
    }

    public function setIdho(?Hotel $idho): self
    {
        $this->idho = $idho;

        return $this;
    }


}
