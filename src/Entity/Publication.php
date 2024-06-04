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
    private ?User $user_id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    /**
     * @var Collection<int, PublicationImages>
     */
    #[ORM\OneToMany(targetEntity: PublicationImages::class, mappedBy: 'id_publication', orphanRemoval: true)]
    private Collection $publicationImages;

    /**
     * @var Collection<int, PublicationMessages>
     */
    #[ORM\OneToMany(targetEntity: PublicationMessages::class, mappedBy: 'publication_id', orphanRemoval: true)]
    private Collection $publicationMessages;

    public function __construct()
    {
        $this->publicationImages = new ArrayCollection();
        $this->publicationMessages = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

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
            $publicationImage->setIdPublication($this);
        }

        return $this;
    }

    public function removePublicationImage(PublicationImages $publicationImage): static
    {
        if ($this->publicationImages->removeElement($publicationImage)) {
            // set the owning side to null (unless already changed)
            if ($publicationImage->getIdPublication() === $this) {
                $publicationImage->setIdPublication(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PublicationMessages>
     */
    public function getPublicationMessages(): Collection
    {
        return $this->publicationMessages;
    }

    public function addPublicationMessage(PublicationMessages $publicationMessage): static
    {
        if (!$this->publicationMessages->contains($publicationMessage)) {
            $this->publicationMessages->add($publicationMessage);
            $publicationMessage->setPublicationId($this);
        }

        return $this;
    }

    public function removePublicationMessage(PublicationMessages $publicationMessage): static
    {
        if ($this->publicationMessages->removeElement($publicationMessage)) {
            // set the owning side to null (unless already changed)
            if ($publicationMessage->getPublicationId() === $this) {
                $publicationMessage->setPublicationId(null);
            }
        }

        return $this;
    }
}
