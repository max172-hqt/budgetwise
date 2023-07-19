<?php

namespace Budgetwise\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

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

    #[ORM\Column(type: 'string')]
    private string $password;

    /**
     * Many Users have Many Trips.
     * @var Collection<int, Trip>
     */
    #[ManyToMany(targetEntity: Trip::class, mappedBy: 'users')]
    private Collection $trips;

    public function __construct()
    {
        $this->trips = new ArrayCollection();
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
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
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

}