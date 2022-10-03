<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PostDislike
 *
 * @ORM\Table(name="post_dislike", indexes={@ORM\Index(name="IDX_C3D35B994B89032C", columns={"post_id"})})
 * @ORM\Entity
 */
class PostDislike
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
     * @var \Offre
     *
     * @ORM\ManyToOne(targetEntity="Offre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * })
     */
    private $post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?Offre
    {
        return $this->post;
    }

    public function setPost(?Offre $post): self
    {
        $this->post = $post;

        return $this;
    }


}
