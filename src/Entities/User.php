<?php

namespace Budgetwise\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
/**
 * One user could have many reported bugs and assigned bugs
 * This is the inverse side of user -> bugs (one to many) relationship
 */
class User
{
    /** @var Collection<int, Bug> */
    #[ORM\OneToMany(mappedBy: 'reported', targetEntity: Bug::class)]
    private Collection $reportedBugs;

    /** @var Collection<int, Bug> */
    #[ORM\OneToMany(mappedBy: 'engineer', targetEntity: Bug::class)]
    private Collection $assignedBugs;

    public function __construct()
    {
        $this->reportedBugs = new ArrayCollection();
        $this->assignedBugs = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    /**
     * @return int
     */
    public function getId(): int|null
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getReportedBugs(): Collection
    {
        return $this->reportedBugs;
    }

    /**
     * @return Collection
     */
    public function getAssignedBugs(): Collection
    {
        return $this->assignedBugs;
    }

    public function assignedToBug(Bug $bug): void
    {
        $this->assignedBugs[] = $bug;
    }

    public function addReportedBug(Bug $bug): void
    {
        $this->reportedBugs[] = $bug;
    }
}