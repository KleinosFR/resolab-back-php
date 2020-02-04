<?php

namespace App\Entity;

use \DateTime;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={"order"={"createdAt": "DESC"}},
 *     normalizationContext={"groups"={"read", "media_object_read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ApiFilter(OrderFilter::class, properties={"createdAt"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(SearchFilter::class, properties={
 *     "user.classRoom.id": "exact"
 * })
 * @ApiFilter(BooleanFilter::class, properties={"display"})
 * @ORM\Entity()
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read", "read_like"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read", "write", "read_like"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"read", "write"})
     */
    private $photo;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read", "write"})
     */
    private $display;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read", "write", "read_like"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alert", mappedBy="post", cascade={"remove"})
     * @Groups({"read_user"})
     */
    private $alerts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post", cascade={"remove"})
     * @Groups({"read", "write"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Likes", mappedBy="post", cascade={"remove"})
     * @Groups({"read"})
     * @ApiSubresource
     */
    private $likes;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read"})
     */
    private $createdAt;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"read", "write"})
     */
    public $image;

    public function __construct()
    {
        $this->display = true;
        $this->comments = new ArrayCollection();
        $this->createdAt = new DateTime();
        $this->likes = new ArrayCollection();
        $this->alerts = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

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
     * @return PersistentCollection|null
     */
    public function getComments(): ?PersistentCollection
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     * @return Post
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    /**
     * @param Comment $comment
     * @return Post
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

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
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return MediaObject|null
     */
    public function getImage(): ?MediaObject
    {
        return $this->image;
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
