<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
class Subscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\OneToOne(mappedBy: 'subscription', cascade: ['persist', 'remove'])]
    private ?SubscriptionHistory $subscriptionHistory = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $streemiUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getSubscriptionHistory(): ?SubscriptionHistory
    {
        return $this->subscriptionHistory;
    }

    public function setSubscriptionHistory(?SubscriptionHistory $subscriptionHistory): static
    {
        // unset the owning side of the relation if necessary
        if ($subscriptionHistory === null && $this->subscriptionHistory !== null) {
            $this->subscriptionHistory->setSubscription(null);
        }

        // set the owning side of the relation if necessary
        if ($subscriptionHistory !== null && $subscriptionHistory->getSubscription() !== $this) {
            $subscriptionHistory->setSubscription($this);
        }

        $this->subscriptionHistory = $subscriptionHistory;

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
