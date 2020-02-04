<?php

namespace App\Entity;

use \DateTime;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ApiFilter(OrderFilter::class, properties={"createdAt"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(SearchFilter::class, properties={
 *     "post.id": "exact"
 * })
 * @ApiFilter(BooleanFilter::class, properties={"display"})
 * @ORM\Entity()
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read", "read_like"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read", "read_like"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $post;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alert", mappedBy="comment", cascade={"remove"})
     * @Groups({"read_user"})
     */
    private $alerts;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read", "read_like"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Likes", mappedBy="comment", orphanRemoval=true)
     */
    private $likes;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read", "write"})
     */
    private $display;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->likes = new ArrayCollection();
        $this->display = true;
        $this->alerts = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Post|null
     */
    public function getPost(): ?Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     * @return $this
     */
    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return PersistentCollection
     */
    public function getLikes(): PersistentCollection
    {
        return $this->likes;
    }

    /**
     * @param \DateTime $createdAt
     * @return Comment
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return bool
     */
    public function isDisplay(): bool
    {
        return $this->display;
    }

    /**
     * @param bool $display
     */
    public function setDisplay(bool $display): self
    {
        $this->display = $display;

        return $this;
    }
}
