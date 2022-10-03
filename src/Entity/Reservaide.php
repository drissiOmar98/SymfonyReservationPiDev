<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservaide
 *
 * @ORM\Table(name="reservaide")
 * @ORM\Entity
 */
class Reservaide
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
     * @ORM\Column(name="id_patient", type="string", length=255, nullable=false)
     */
    private $idPatient;

    /**
     * @var string
     *
     * @ORM\Column(name="id_aide", type="string", length=255, nullable=false)
     */
    private $idAide;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=false)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=255, nullable=false)
     */
    private $img;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPatient(): ?string
    {
        return $this->idPatient;
    }

    public function setIdPatient(string $idPatient): self
    {
        $this->idPatient = $idPatient;

        return $this;
    }

    public function getIdAide(): ?string
    {
        return $this->idAide;
    }

    public function setIdAide(string $idAide): self
    {
        $this->idAide = $idAide;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }


}
