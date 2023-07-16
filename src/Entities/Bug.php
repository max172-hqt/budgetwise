<?php

namespace Budgetwise\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'bugs')]
/**
 * Bug will hold the foreign key of engineer and reporter
 * Therefore, it will be the owning side of user -> bugs relationship
 */
class Bug
{
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'assignedBugs')]
    private User $engineer;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reportedBugs')]
    private User $reporter;

    /** @var Collection<int, Product> */
    #[ORM\ManyToMany(targetEntity: Product::class)]
    private Collection $products;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id;

    #[ORM\Column(type: 'string')]
    private string $description;

    #[ORM\Column(type: 'string')]
    private string $status;

    #[ORM\Column(type: 'datetime')]
    private DateTime $created;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created): void
    {
        $this->created = $created;
    }

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param User $engineer
     */
    public function setEngineer(User $engineer): void
    {
        $engineer->assignedToBug($this);
        $this->engineer = $engineer;
    }

    /**
     * @param User $reporter
     */
    public function setReporter(User $reporter): void
    {
        $reporter->addReportedBug($this);
        $this->reporter = $reporter;
    }

    /**
     * @return User
     */
    public function getEngineer(): User
    {
        return $this->engineer;
    }

    /**
     * @return User
     */
    public function getReporter(): User
    {
        return $this->reporter;
    }

    public function assignToProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

}