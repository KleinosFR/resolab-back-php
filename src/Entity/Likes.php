<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(normalizationContext={"groups"={"read"}})
 * @ORM\Entity()
 * @ApiFilter(SearchFilter::class, properties={
 *     "post.id": "exact",
 *     "comment.id": "exact",
 *     "user.id": "exact",
 * })
 */
class Likes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="likes")
     * @Groups({"read"})
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="likes")
     * @Groups({"read"})
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        if ($post instanceof Post) {
            $this->post = $post;
            $this->comment = null;
        }

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        if ($comment instanceof Comment) {
            $this->comment = $comment;
            $this->post = null;
        }

        return $this;
    }
}
