<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FacturesClients
 *
 * @ORM\Table(name="factures_clients")
 *@ORM\Entity(repositoryClass="App\Repository\FacturesClientsRepository")

 */
class FacturesClients
{
    /**
     * @var int

     * @ORM\Column(name="id_Fac", type="integer", length=42, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFac;

    /**
     * @var int
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="nom_client", type="string", length=42, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     */
    private $nomClient;

    /**
     * @var \DateTime
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="date_fac", type="date", nullable=false)
     */
    private $dateFac;

    /**
     * @var string
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="reglement_fac", type="string", length=42, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     */
    private $reglementFac;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_fac", type="string", length=42, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     */
    private $etatFac;

    /**
     * @var int
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="TVA_fac", type="integer", nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     */
    private $tvaFac;

    /**
     * @var int
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="remise_fac", type="integer", nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     */
    private $remiseFac;

    /**
     * @var string
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="NB_fac", type="string", length=42, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     */
    private $nbFac;

    /**
     * @var int
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="Totale_fac", type="integer", nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     */
    private $totaleFac;

    /**
     * @Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\ManyToOne(targetEntity=Banque::class, inversedBy="Factures")

     */
    private $banque;


    public function getIdFac(): ?int
    {
        return $this->idFac;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getDateFac(): ?\DateTimeInterface
    {
        return $this->dateFac;
    }

    public function setDateFac(\DateTimeInterface $dateFac): self
    {
        $this->dateFac = $dateFac;

        return $this;
    }

    public function getReglementFac(): ?string
    {
        return $this->reglementFac;
    }

    public function setReglementFac(string $reglementFac): self
    {
        $this->reglementFac = $reglementFac;

        return $this;
    }

    public function getEtatFac(): ?string
    {
        return $this->etatFac;
    }

    public function setEtatFac(string $etatFac): self
    {
        $this->etatFac = $etatFac;

        return $this;
    }

    public function getTvaFac(): ?int
    {
        return $this->tvaFac;
    }

    public function setTvaFac(int $tvaFac): self
    {
        $this->tvaFac = $tvaFac;

        return $this;
    }

    public function getRemiseFac(): ?int
    {
        return $this->remiseFac;
    }

    public function setRemiseFac(int $remiseFac): self
    {
        $this->remiseFac = $remiseFac;

        return $this;
    }

    public function getNbFac(): ?string
    {
        return $this->nbFac;
    }

    public function setNbFac(string $nbFac): self
    {
        $this->nbFac = $nbFac;

        return $this;
    }

    public function getTotaleFac(): ?int
    {
        return $this->totaleFac;
    }

    public function setTotaleFac(int $totaleFac): self
    {
        $this->totaleFac = $totaleFac;

        return $this;
    }

    public function getIdresde(): ?string
    {
        return $this->idresde;
    }

    public function setIdresde(string $idresde): self
    {
        $this->idresde = $idresde;

        return $this;
    }

    public function getBanque(): ?Banque
    {
        return $this->banque;
    }

    public function setBanque(?Banque $banque): self
    {
        $this->banque = $banque;

        return $this;
    }


}
