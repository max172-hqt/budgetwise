<?php

namespace Budgetwise\Entities;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Money\Money;

/**
 * Transaction table
 * id: integer
 * name: string
 */
#[ORM\Entity]
#[ORM\Table(name: 'transactions')]
class Transaction
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 180)]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $amount; // For simplicity, make everything USD right now

    #[ORM\Column(type: 'datetime')]
    private DateTime $created;

    /** Many transactions have one user. This is the owning side. */
    #[ManyToOne(targetEntity: User::class, inversedBy: 'transactions')]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user = null;

    /** Many transactions belong to one trip. This is the owning side. */
    #[ManyToOne(targetEntity: Trip::class, inversedBy: 'transactions')]
    #[JoinColumn(name: 'trip_id', referencedColumnName: 'id')]
    private ?Trip $trip = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return Money::USD($this->amount);
    }

    /**
     * @param Money $amount
     */
    public function setAmount(Money $amount): void
    {
        $this->amount = $amount->getAmount();
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $user->addTransaction($this);
        $this->user = $user;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param Trip|null $trip
     */
    public function setTrip(?Trip $trip): void
    {
        $trip->addTransaction($this);
        $this->trip = $trip;
    }

    /**
     * @return Trip|null
     */
    public function getTrip(): ?Trip
    {
        return $this->trip;
    }
}