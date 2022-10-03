<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ReservationPanier
 *
 * @ORM\Table(name="reservation_panier")
 * @ORM\Entity
 */
class ReservationPanier
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
     * @ORM\Column(type="array")
     */
    private $items = [];

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $date ;

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }


    public function getId(): ?int
    {
        return $this->id;

    }

    public function getItems(): ?array
    {
        return $this->items;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        $this->date = new \DateTime('now');
        return $this;
    }



}
