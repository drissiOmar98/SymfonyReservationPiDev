<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Offre
 *
 * @ORM\Table(name="offre", indexes={@ORM\Index(name="id_reservation", columns={"id_res"})})
 * @ORM\Entity
 */
class Offre
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "The full name must be at least {{ limit }} characters long",
     *      maxMessage = "The full name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false)
     */
    private $nom;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_validite", type="datetime", nullable=false)
     */
    private $dateValidite;

    /**
     * @var string
     *
     * @ORM\Column(name="taux_de_remise", type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     */
    private $tauxDeRemise;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     *
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="Path_video", type="string", length=255, nullable=false)
     */
    private $pathVideo;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var \ReservationPanier
     *
     * @ORM\ManyToOne(targetEntity="ReservationPanier")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_res", referencedColumnName="id")
     * })
     */
    private $idRes;


    /**
     * @ORM\OneToMany(targetEntity=PostLike::class, mappedBy="post")
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=PostDislike::class, mappedBy="post")
     */
    private $dislikes;


    /**
     * @var \Commentaire
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="post", orphanRemoval=true)
     */
    private $comments;



    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments): void
    {
        $this->comments = $comments;
    }








    /**
     * @return Collection|PostDislike[]
     */
    public function getdislikes(): Collection
    {
        return $this->dislikes;
    }



    /**
     * @return Collection|PostLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateValidite(): ?\DateTimeInterface
    {
        return $this->dateValidite;
    }

    public function setDateValidite(\DateTimeInterface $dateValidite): self
    {
        $this->dateValidite = $dateValidite;

        return $this;
    }

    public function getTauxDeRemise(): ?string
    {
        return $this->tauxDeRemise;
    }

    public function setTauxDeRemise(string $tauxDeRemise): self
    {
        $this->tauxDeRemise = $tauxDeRemise;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath( $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getPathVideo(): ?string
    {
        return $this->pathVideo;
    }

    public function setPathVideo(string $pathVideo): self
    {
        $this->pathVideo = $pathVideo;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIdRes(): ?ReservationPanier
    {
        return $this->idRes;
    }

    public function setIdRes(?ReservationPanier $idRes): self
    {
        $this->idRes = $idRes;

        return $this;
    }


    public function addDisLike(PostDislike $like): self
    {
        if (!$this->dislikes->contains($like)) {
            $this->dislikes[] = $like;
            $like->setPost($like);
        }

        return $this;
    }





    public function addLike(PostLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setPost($like);
        }

        return $this;
    }



    /*

    public function removeLike(PostLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getPost() === $this) {
                $like->setPost(null);
            }
        }

        return $this;
    }

*/




    /*
        /**
         * @param Userlike $user
         * @return boolean
         */
    /*
        public function isLikedByUser(Userlike $user) :bool
        {
            foreach($this->likes as $like){
                if($like->getUser() ===$user)
                    return true;
            }
            return false;
        }


    */







}
