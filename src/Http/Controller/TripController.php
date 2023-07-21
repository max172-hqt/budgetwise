<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Budgetwise\Core\BudgetCalculation;
use Budgetwise\Entities\Trip;
use Budgetwise\Entities\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TripController extends AbstractController
{
    public function index(Request $request): Response
    {
        $currentUser = $this->getCurrentUser();

        if (!$currentUser) {
            $request->getSession()->invalidate();
            return $this->render('trip/index.html.twig', [
                'heading' => 'My Trips',
                'email' =>  'Guest',
            ]);
        }

        return $this->render('trip/index.html.twig', [
            'heading' => 'My Trips',
            'email' => $currentUser->getEmail(),
            'trips' => $currentUser->getTrips()
        ]);
    }

    public function show(Request $request, int $id): Response
    {
        $currentUser = $this->getCurrentUser();
        $trip = $this->entityManager()->find(Trip::class, $id);
        $authorized = $trip->getUsers()->findFirst(function (int $key, User $user) use ($currentUser) {
            return $user->getId() === $currentUser->getId();
        });

        if (!$authorized) {
            // TODO: Create error page
            return new Response('You are not authorized to see this page');
        }

        $calculation = new BudgetCalculation($trip);
        $calculation->resolvedTable();

        return $this->render('trip/show.html.twig', [
            'heading' => $trip->getName(),
            'trip' => $trip,
            'transactions' => $trip->getTransactions(),
            'budgetTable' => $calculation->budgetTable(),
            'resolvedTable' => $calculation->resolvedTable(),
        ]);
    }

    public function create(): Response
    {
        $users = $this->entityManager()->getRepository(User::class)->findAll();

        return $this->render('trip/create.html.twig', [
            'heading' => 'Create a new trip',
            'users' => $users
        ]);
    }

    public function store(Request $request): Response
    {
        $name = $request->get('name');
        $userIds = array_filter($request->getPayload()->keys(), fn($key) => $key !== 'name');
        $trip = new Trip();

        $trip->setName($name);
        $users = $this->entityManager()->getRepository(User::class)->findBy([
            'id' => $userIds
        ]);

        foreach ($users as $user) {
            $trip->addUser($user);
        }

        $trip->addUser($this->getCurrentUser());

        $this->db->persistAndFlush($trip);

        return $this->redirect();
    }
}