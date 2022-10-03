<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Books
 *
 * @ORM\Table(name="books")
 *@ORM\Entity(repositoryClass="App\Repository\BooksRepository")
 */
class Books
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
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     * @var string
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="equipement", type="string", length=255, nullable=false)
     */
    private $equipement;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     * @Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="code", type="string", length=255, nullable=false)
     */
    private $code;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     * @var string
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     * @var string
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="employe", type="string", length=255, nullable=false)
     */
    private $employe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipement(): ?string
    {
        return $this->equipement;
    }

    public function setEquipement(string $equipement): self
    {
        $this->equipement = $equipement;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getEmploye(): ?string
    {
        return $this->employe;
    }

    public function setEmploye(string $employe): self
    {
        $this->employe = $employe;

        return $this;
    }


}
