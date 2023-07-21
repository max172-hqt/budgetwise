<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Budgetwise\Entities\Transaction;
use Budgetwise\Entities\Trip;
use DateTime;
use Money\Money;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends AbstractController
{
    public function store(Request $request, $id): Response
    {
        $name = $request->get('name');
        $amount = $request->get('amount');

        $currentUser = $this->getCurrentUser();
        $trip = $this->db->entityManager()->find(Trip::class, $id);

        $transaction = new Transaction();
        $transaction->setName($name);
        $transaction->setUser($currentUser);
        $transaction->setTrip($trip);
        $transaction->setCreated(new DateTime('now'));

        if (!str_contains($amount, '.') && !str_contains($amount, ',')) {
            $amount .= "00";
        } else {
            $amount = str_replace('.', '', $amount);
            $amount = str_replace(',', '', $amount);
        }

        $transaction->setAmount(Money::USD($amount));
        $this->db->persistAndFlush($transaction);

        return $this->redirect("/trips/{$id}");
    }
}