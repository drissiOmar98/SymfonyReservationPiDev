<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PostL
 *
 * @ORM\Table(name="post_l", indexes={@ORM\Index(name="IDX_653627B84B89032C", columns={"post_id"}), @ORM\Index(name="IDX_653627B8A76ED395", columns={"user_id"})})
 * @ORM\Entity
 */
class PostL
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
     * @var \Events
     *
     * @ORM\ManyToOne(targetEntity="Events")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * })
     */
    private $post;

    /**
     * @var \Userlike
     *
     * @ORM\ManyToOne(targetEntity="Userlike")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPost(): ?Events
    {
        return $this->post;
    }

    public function setPost(?Events $post): self
    {
        $this->post = $post;

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
