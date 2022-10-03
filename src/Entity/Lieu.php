<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Lieu
 *
 * @ORM\Table(name="lieu")
 *@ORM\Entity(repositoryClass="App\Repository\LieuRepository")
 */
class Lieu
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdL", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idl;

    /**
     * @var string
     *
     * @ORM\Column(name="lieux", type="string", length=255)
     *
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     */
    private $lieux;

    /**
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="lieus")
     */
    private $Hootels;

    public function getIdl(): ?int
    {
        return $this->idl;
    }

    public function getLieux(): ?string
    {
        return $this->lieux;
    }

    public function setLieux(string $lieux): self
    {
        $this->lieux = $lieux;

        return $this;
    }

    public function getHootels(): ?Hotel
    {
        return $this->Hootels;
    }

    public function setHootels(?Hotel $Hootels): self
    {
        $this->Hootels = $Hootels;

        return $this;
    }


}
