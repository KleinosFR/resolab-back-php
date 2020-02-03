<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read_user"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiFilter(SearchFilter::class, properties={
 *     "username": "exact"
 * })
 */
class User implements UserInterface
{
    const GENDERS = ['male', 'female'];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read_user", "read", "read_like"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"read_user", "read", "read_like"})
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Groups({"read_user"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @Groups({"read_user"})
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read_user"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read_user"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     * @Assert\Choice(choices=USER::GENDERS, message="Choose a valid gender.")
     * @Groups({"read_user"})
     */
    private $gender;

    /**
     * @ORM\Column(type="date", nullable=true, nullable=true)
     * @Groups({"read_user"})
     */
    private $birthday;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user")
     * @Groups({"read_user"})
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Story", mappedBy="user")
     * @Groups({"read_user"})
     */
    private $stories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     * @Groups({"read_user"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Time", mappedBy="user")
     * @Groups({"read_user"})
     */
    private $times;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Likes", mappedBy="user", orphanRemoval=true)
     * @Groups({"read_user"})
     */
    private $likes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ClassRoom", inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"read_user", "read", "read_like"})
     */
    private $classRoom;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read_user"})
     */
    private $isRestricted;

    public function __construct($username)
    {
        $this->isActive = true;
        $this->isRestricted = true;
        $this->username = $username;
        $this->posts = new ArrayCollection();
        $this->stories = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->times = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return bool
     */
    public function getisActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getClassRoom(): ?ClassRoom
    {
        return $this->classRoom;
    }

    public function setClassRoom(?ClassRoom $classRoom): self
    {
        $this->classRoom = $classRoom;

        return $this;
    }

    /**
     * @return PersistentCollection|Post[]
     */
    public function getPosts(): PersistentCollection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return PersistentCollection|Post[]
     */
    public function getStories(): PersistentCollection
    {
        return $this->stories;
    }

    public function addStory(Story $story): self
    {
        if (!$this->stories->contains($story)) {
            $this->stories[] = $story;
            $story->setUser($this);
        }

        return $this;
    }

    public function removeStory(Story $story): self
    {
        if ($this->stories->contains($story)) {
            $this->stories->removeElement($story);
            // set the owning side to null (unless already changed)
            if ($story->getUser() === $this) {
                $story->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return PersistentCollection|Post[]
     */
    public function getComments(): PersistentCollection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Time[]
     */
    public function getTimes(): Collection
    {
        return $this->times;
    }

    /**
     * @return PersistentCollection
     */
    public function getLikes(): PersistentCollection
    {
        return $this->likes;
    }

    /**
     * @return bool
     */
    public function getisRestricted(): bool
    {
        return $this->isRestricted;
    }

    /**
     * @param bool $isRestricted
     */
    public function setIsRestricted(bool $isRestricted): self
    {
        $this->isRestricted = $isRestricted;

        return $this;
    }
}
