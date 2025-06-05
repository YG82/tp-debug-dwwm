<?php

namespace App\Entity;

use App\Repository\NetworkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NetworkRepository::class)]
#[Broadcast]
#[ORM\HasLifecycleCallbacks] // Gestion du cycle de vie d' l'objet 
class Network
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[Assert\NotBlank(message: 'Le champ url est obligatoire')]
    #[Assert\Url(message: 'Le champ url doit être une URL valide')]
    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[Assert\NotBlank(message: 'Le champ type est obligatoire')]
    #[Assert\Choice(
        choices: ['facebook', 'twitter', 'youtube', 'instagram', 'tiktok', 'reddit', 'linkedin'], 
        message: 'Le champ type doit être une des valeurs suivantes : ')]
    #[ORM\Column(length: 80)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'networks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\PrePersist] // Enregistrement délégué à l'ORM Doctrine pour la valeur created_at + updated_at
    public function setCreatedAtValue(): void
    {
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate] // Enregistrement délégué à l'ORM Doctrine pour la valeur updated_at
    public function setUpdatedAtValue(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
