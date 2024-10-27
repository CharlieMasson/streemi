<?php

namespace App\Entity;

use App\Repository\SubscriptionHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionHistoryRepository::class)]
class SubscriptionHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\OneToOne(inversedBy: 'subscriptionHistory', cascade: ['persist', 'remove'])]
    private ?subscription $subscription = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptionHistories')]
    private ?user $streemiUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getSubscription(): ?subscription
    {
        return $this->subscription;
    }

    public function setSubscription(?subscription $subscription): static
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getStreemiUser(): ?user
    {
        return $this->streemiUser;
    }

    public function setStreemiUser(?user $streemiUser): static
    {
        $this->streemiUser = $streemiUser;

        return $this;
    }
}