<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Banque
 *
 * @ORM\Table(name="banque")
 *@ORM\Entity(repositoryClass="App\Repository\BanqueRepository")

 */
class Banque
{
    /**
     * @var int
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
     * @ORM\Column(name="nom_banque", type="string", length=255, nullable=false)

     */
    private $nomBanque;

    /**

     * @var int
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="code", type="integer", nullable=false)
     */
    private $code;

    /**
     * @var int

     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="pass", type="integer", nullable=false)
     */
    private $pass;

    /**
     * @var int
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\Column(name="solde", type="integer", nullable=false)
     */
    private $solde;

    /**
     *@Assert\NotBlank
     * message= " ce champs est obligatoire "
     * @ORM\OneToMany(targetEntity=FacturesClients::class, mappedBy="banque",cascade={"all"},orphanRemoval=true)
     */
    private $Factures;

    public function __construct()
    {
        $this->Factures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomBanque(): ?string
    {
        return $this->nomBanque;
    }

    public function setNomBanque(string $nomBanque): self
    {
        $this->nomBanque = $nomBanque;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getPass(): ?int
    {
        return $this->pass;
    }

    public function setPass(int $pass): self
    {
        $this->pass = $pass;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * @return Collection|FacturesClients[]
     */
    public function getFactures(): Collection
    {
        return $this->Factures;
    }

    public function addFacture(FacturesClients $facture): self
    {
        if (!$this->Factures->contains($facture)) {
            $this->Factures[] = $facture;
            $facture->setBanque($this);
        }

        return $this;
    }

    public function removeFacture(FacturesClients $facture): self
    {
        if ($this->Factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getBanque() === $this) {
                $facture->setBanque(null);
            }
        }

        return $this;
    }


}
