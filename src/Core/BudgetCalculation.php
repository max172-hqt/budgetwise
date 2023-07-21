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

    /**
     * Get the contribution that each member must make
     * @return Money
     */
    public function getContribution(): Money
    {
        return $this->getTotalCost()->divide($this->users()->count());
    }

    /**
     * @return array
     */
    public function budgetTable(): array
    {
        $table = [];

        foreach ($this->users() as $user) {
            $table[$user->getEmail()] = [
                'total_pay' => Money::USD(0)
            ];
        }

        foreach ($this->transactions() as $transaction) {
            $email = $transaction->getUser()->getEmail();
            $table[$email] = [
                'total_pay' => $table[$email]['total_pay']->add($transaction->getAmount())
            ];
        }

        foreach ($table as $email => $info) {
            $table[$email]['own'] = $info['total_pay']->subtract($this->getContribution());
        }

        $res = [];

        foreach ($table as $email => $props) {
            $res[] = [
                'email' => $email,
                ...$props,
            ];
        }

        return $res;
    }

    public function resolvedTable(): array
    {
        $table = $this->budgetTable();

        // Sort by the 'own' property, those who owe most will come first
        usort($table, function ($a, $b) {
            return $a['own']->compare($b['own']);
        });

        $start = 0;
        $end = count($table) - 1;

        $resolveTable = [];

        while ($start < $end) {
            $owe = $table[$start]['own'];
            $own = $table[$end]['own'];

            $oweAbs = $owe->absolute();
            $ownAbs = $own->absolute();

            $amount = Money::min($oweAbs, $ownAbs);

            $table[$start]['own'] = $table[$start]['own']->add($amount);
            $table[$end]['own'] = $table[$end]['own']->subtract($amount);

            $resolveTable[$table[$start]['email']][$table[$end]['email']] = $amount;

            if ($table[$start]['own']->isZero() || $table[$start]['own']->isPositive()) {
                $start++;
            }

            if ($table[$end]['own']->isZero() || $table[$end]['own']->isNegative()) {
                $end--;
            }
        }

        return $resolveTable;
    }
}