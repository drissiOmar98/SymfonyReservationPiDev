<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PostLike
 *
 * @ORM\Table(name="post_like", indexes={@ORM\Index(name="IDX_653627B84B89032C", columns={"post_id"}), @ORM\Index(name="IDX_653627B8A76ED395", columns={"user_id"})})
 * @ORM\Entity
 */
class PostLike
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
     * @var \Userlike
     *
     * @ORM\ManyToOne(targetEntity="Userlike")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Offre
     *
     * @ORM\ManyToOne(targetEntity="Offre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * })
     */
    private $post;




    public function getPost(): ?Offre
    {
        return $this->post;
    }

    public function setPost(?Offre $post): self
    {
        $this->post = $post;

        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostId(): ?int
    {
        return $this->postId;
    }

    public function setPostId(?int $postId): self
    {
        $this->postId = $postId;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }


}
