<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Publication>
     */
    #[ORM\OneToMany(targetEntity: Publication::class, mappedBy: 'user_id', orphanRemoval: true)]
    private Collection $publications;

    /**
     * @var Collection<int, PublicationComments>
     */
    #[ORM\OneToMany(targetEntity: PublicationComments::class, mappedBy: 'user_id', orphanRemoval: true)]
    private Collection $publicationComments;

    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * @var Collection<int, PublicationReactions>
     */
    #[ORM\OneToMany(targetEntity: PublicationReactions::class, mappedBy: 'user')]
    private Collection $publicationReactions;

    public function __construct()
    {
        $this->publications = new ArrayCollection();
        $this->publicationComments = new ArrayCollection();
        $this->publicationReactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Publication>
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): static
    {
        if (!$this->publications->contains($publication)) {
            $this->publications->add($publication);
            $publication->setUserId($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): static
    {
        if ($this->publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getUserId() === $this) {
                $publication->setUserId(null);
            }
        }

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
            $publicationComment->setUserId($this);
        }

        return $this;
    }

    public function removePublicationComment(PublicationComments $publicationComment): static
    {
        if ($this->publicationComments->removeElement($publicationComment)) {
            // set the owning side to null (unless already changed)
            if ($publicationComment->getUserId() === $this) {
                $publicationComment->setUserId(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

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
            $publicationReaction->setUser($this);
        }

        return $this;
    }

    public function removePublicationReaction(PublicationReactions $publicationReaction): static
    {
        if ($this->publicationReactions->removeElement($publicationReaction)) {
            // set the owning side to null (unless already changed)
            if ($publicationReaction->getUser() === $this) {
                $publicationReaction->setUser(null);
            }
        }

        return $this;
    }
}
