<?php

namespace App\Entity;

use \DateTime;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ApiResource(
 *     attributes={"order"={"date": "DESC"}},
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"display"})
 * @ORM\Entity()
 */
class Story
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read","write"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alert", mappedBy="story", cascade={"remove"})
     * @Groups({"read_user"})
     */
    private $alerts;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read"})
     */
    private $date;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"read", "write"})
     */
    public $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="stories")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read", "write"})
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read", "write"})
     */
    private $display;

    public function __construct()
    {
        $this->date = new DateTime();
        $this->display = true;
        $this->alerts = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return MediaObject|null
     */
    public function getImage(): ?MediaObject
    {
        return $this->image;
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
