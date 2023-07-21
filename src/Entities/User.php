<?php

namespace Budgetwise\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
/**
 * User table
 * id: integer
 * email: string
 * password: string, hashed
 */
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string', length: 180)]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $password;

    /**
     * Many Users have Many Trips.
     * @var Collection<int, Trip>
     */
    #[ManyToMany(targetEntity: Trip::class, mappedBy: 'users')]
    private Collection $trips;

    /**
     * One user can have many transaction, so users are inversed side
     * @var Collection
     */
    #[OneToMany(mappedBy: 'user', targetEntity: Transaction::class)]
    private Collection $transactions;


    public function __construct()
    {
        $this->trips = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param $password string password to check against
     * @return bool
     */
    public function isPasswordMatched(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @return Collection
     */
    public function getTrips(): Collection
    {
        return $this->trips;
    }

    /**
     * @param Collection $trips
     */
    public function setTrips(Collection $trips): void
    {
        $this->trips = $trips;
    }

    public function addTrip(Trip $trip): void
    {
        $this->trips[] = $trip;
    }

    /**
     * @param Collection $transactions
     */
    public function setTransactions(Collection $transactions): void
    {
        $this->transactions = $transactions;
    }

    /**
     * @return Collection
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): void
    {
        $this->transactions[] = $transaction;
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
}