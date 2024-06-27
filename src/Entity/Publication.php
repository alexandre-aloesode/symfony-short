<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'publications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, PublicationComments>
     */
    #[ORM\OneToMany(targetEntity: PublicationComments::class, mappedBy: 'publication_id', orphanRemoval: true)]
    private Collection $publicationComments;

    /**
     * @var Collection<int, PublicationImages>
     */
    #[ORM\OneToMany(targetEntity: PublicationImages::class, mappedBy: 'publication_id', orphanRemoval: true)]
    private Collection $publicationImages;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    /**
     * @var Collection<int, PublicationReactions>
     */
    #[ORM\OneToMany(targetEntity: PublicationReactions::class, mappedBy: 'publication', orphanRemoval: true)]
    private Collection $publicationReactions;

    public function __construct()
    {
        $this->publicationComments = new ArrayCollection();
        $this->publicationImages = new ArrayCollection();
        $this->publicationReactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, PublicationComments>
     */
    public function getPublicationComments(): Collection
    {
        return $this->publicationComments;
    }

    public function addPublicationComment(PublicationComments $publicationComment): static
    {
        if (!$this->publicationComments->contains($publicationComment)) {
            $this->publicationComments->add($publicationComment);
            $publicationComment->setPublicationId($this);
        }

        return $this;
    }

    public function removePublicationComment(PublicationComments $publicationComment): static
    {
        if ($this->publicationComments->removeElement($publicationComment)) {
            // set the owning side to null (unless already changed)
            if ($publicationComment->getPublicationId() === $this) {
                $publicationComment->setPublicationId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PublicationImages>
     */
    public function getPublicationImages(): Collection
    {
        return $this->publicationImages;
    }

    public function setPublicationImages(Collection $publicationImages): static
    {
        $this->publicationImages = $publicationImages;

        return $this;
    }

    public function addPublicationImage(PublicationImages $publicationImage): static
    {
        if (!$this->publicationImages->contains($publicationImage)) {
            $this->publicationImages->add($publicationImage);
            $publicationImage->setPublicationId($this);
        }

        return $this;
    }

    public function removePublicationImage(PublicationImages $publicationImage): static
    {
        if ($this->publicationImages->removeElement($publicationImage)) {
            // set the owning side to null (unless already changed)
            if ($publicationImage->getPublicationId() === $this) {
                $publicationImage->setPublicationId(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, PublicationReactions>
     */
    public function getPublicationReactions(): Collection
    {
        return $this->publicationReactions;
    }

    public function addPublicationReaction(PublicationReactions $publicationReaction): static
    {
        if (!$this->publicationReactions->contains($publicationReaction)) {
            $this->publicationReactions->add($publicationReaction);
            $publicationReaction->setPublication($this);
        }

        return $this;
    }

    public function removePublicationReaction(PublicationReactions $publicationReaction): static
    {
        if ($this->publicationReactions->removeElement($publicationReaction)) {
            // set the owning side to null (unless already changed)
            if ($publicationReaction->getPublication() === $this) {
                $publicationReaction->setPublication(null);
            }
        }

        return $this;
    }
}
