<?php

namespace Budgetwise\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity]
#[ORM\Table(name: 'trips')]
/**
 * Trip table
 * id: integer
 * name: string
 */
class Trip
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'string')]
    private string $name;

    /**
     * Many Trips have Many Users.
     * trips is the owning side
     * since it makes more sense to add user to a trip
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'trips')]
    #[ORM\JoinTable(name: 'trips_users')]
    private Collection $users;

    /**
     * One trip can have many transaction, so users are inversed side
     * @var Collection
     */
    #[OneToMany(mappedBy: 'trip', targetEntity: Transaction::class)]
    private Collection $transactions;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
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
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param Collection $users
     */
    public function setUsers(Collection $users): void
    {
        $this->users = $users;
    }


    public function addUser(User $user): void
    {
        $user->addTrip($this); // synchronously update the inverse side
        $this->users[] = $user;
    }

    /**
     * @return Collection
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    /**
     * @param Collection $transactions
     */
    public function setTransactions(Collection $transactions): void
    {
        $this->transactions = $transactions;
    }

    public function addTransaction(Transaction $transaction): void
    {
        $this->transactions[] = $transaction;
    }
}