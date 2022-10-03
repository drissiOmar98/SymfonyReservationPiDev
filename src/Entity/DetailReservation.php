<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetailReservation
 *
 * @ORM\Table(name="detail_reservation", uniqueConstraints={@ORM\UniqueConstraint(name="idCli", columns={"idCli"})}, indexes={@ORM\Index(name="idT", columns={"idT"}), @ORM\Index(name="idH", columns={"idH"}), @ORM\Index(name="idV", columns={"idV"})})
 * @ORM\Entity
 */
class DetailReservation
{
    /**
     * @var string
     *
     * @ORM\Column(name="iddetail", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddetail;

    /**
     * @var string
     *
     * @ORM\Column(name="idH", type="string", length=255, nullable=false)
     */
    private $idh;

    /**
     * @var string
     *
     * @ORM\Column(name="idT", type="string", length=255, nullable=false)
     */
    private $idt;

    /**
     * @var string
     *
     * @ORM\Column(name="idV", type="string", length=255, nullable=false)
     */
    private $idv;

    /**
     * @var string
     *
     * @ORM\Column(name="idoffr", type="string", length=255, nullable=false)
     */
    private $idoffr;

    /**
     * @var string
     *
     * @ORM\Column(name="idCli", type="string", length=255, nullable=false)
     */
    private $idcli;

    /**
     * @var string
     *
     * @ORM\Column(name="ideven", type="string", length=255, nullable=false)
     */
    private $ideven;

    /**
     * @var int
     *
     * @ORM\Column(name="prixT", type="integer", nullable=false)
     */
    private $prixt;

    public function getIddetail(): ?string
    {
        return $this->iddetail;
    }

    public function getIdh(): ?string
    {
        return $this->idh;
    }

    public function setIdh(string $idh): self
    {
        $this->idh = $idh;

        return $this;
    }

    public function getIdt(): ?string
    {
        return $this->idt;
    }

    public function setIdt(string $idt): self
    {
        $this->idt = $idt;

        return $this;
    }

    public function getIdv(): ?string
    {
        return $this->idv;
    }

    public function setIdv(string $idv): self
    {
        $this->idv = $idv;

        return $this;
    }

    public function getIdoffr(): ?string
    {
        return $this->idoffr;
    }

    public function setIdoffr(string $idoffr): self
    {
        $this->idoffr = $idoffr;

        return $this;
    }

    public function getIdcli(): ?string
    {
        return $this->idcli;
    }

    public function setIdcli(string $idcli): self
    {
        $this->idcli = $idcli;

        return $this;
    }

    public function getIdeven(): ?string
    {
        return $this->ideven;
    }

    public function setIdeven(string $ideven): self
    {
        $this->ideven = $ideven;

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


}
