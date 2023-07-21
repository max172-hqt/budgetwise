<?php

namespace Budgetwise\Core;

use Budgetwise\Entities\Transaction;
use Budgetwise\Entities\Trip;
use Budgetwise\Entities\User;
use Doctrine\Common\Collections\Collection;
use Money\Money;

class BudgetCalculation
{
    protected Trip $trip;

    /**
     * @param Trip $trip Trip to calculate the cost and budget split
     */
    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function transactions(): Collection
    {
        return $this->trip->getTransactions();
    }

    /**
     * @return Collection<int, User>
     */
    public function users(): Collection
    {
        return $this->trip->getUsers();
    }

    /**
     * Get total trip cost
     *
     * @return Money
     */
    public function getTotalCost(): Money
    {
        $total = Money::USD(0);

        foreach ($this->transactions() as $transaction) {
            $total = $total->add($transaction->getAmount());
        }

        return $total;
    }

    public function getContribution(): Money
    {
        return $this->getTotalCost()->divide($this->users()->count());
    }

    /**
     * @return array<string, Money>
     */
    public function budgetTable(): array
    {
        $table = [];

        foreach ($this->transactions() as $transaction) {
            $email = $transaction->getUser()->getEmail();
            if (!isset($table[$email])) {
                $table[$email] = [
                    'total_pay' => $transaction->getAmount()
                ];
            } else {
                $table[$email] = [
                    'total_pay' => $table[$email]['total_pay']->add($transaction->getAmount())
                ];
            }
        }

        foreach ($table as $email => $info) {
            $table[$email]['own'] = $info['total_pay']->subtract($this->getContribution());
        }

        return $table;
    }
}