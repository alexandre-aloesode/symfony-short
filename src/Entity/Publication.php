<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?User $user_id = null;

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

    public function __construct()
    {
        $this->publicationComments = new ArrayCollection();
        $this->publicationImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

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
}
