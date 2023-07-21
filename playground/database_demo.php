<?php

use Budgetwise\Core\App;
use Budgetwise\Core\Database;
use Budgetwise\Entities\Transaction;
use Budgetwise\Entities\Trip;
use Budgetwise\Entities\User;
use Money\Money;

const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . 'src/Utilities/functions.php';

require base_path('/vendor/autoload.php');

/** @var \DI\Container $container */
$container = require base_path('bootstrap.php');

/** @var Database $db */
$db = $container->make(Database::class);

// ============================ CREATE TRIP ============================
//$tripName = $argv[1];
//
//$trip = new \Budgetwise\Entities\Trip();
//$trip->setName($tripName);
//$db->persistAndFlush($trip);
//
//echo "Created Trip with ID " . $trip->getId() . "\n";

// ============================ CREATE USER ============================
//$newEmail = $argv[1];
//$newPassword = $argv[2];
//
//$user = new User();
//$user->setEmail($newEmail);
//$user->setPassword($newPassword);
//
//$db->persistAndFlush($user);
//
//echo "Created User with ID " . $user->getId() . "\n";

// ============================ ADD USER TO TRIP ============================
//$userId = $argv[1];
//$tripIds = explode(',', $argv[2]);
//$user = $db->entityManager()->find(User::class, $userId);
//
//if (!$userId) {
//    echo "No user found for the given id(s).\n";
//    exit(1);
//}
//
//foreach ($tripIds as $tripId) {
//    $trip = $db->entityManager()->find(Trip::class, $tripId);
//    $trip->addUser($user);
//}
//
//$db->persistAndFlush($trip);


// ============================ ADD TRANSACTION ============================
$userId = $argv[1];
$tripId = $argv[2];
$transactionName = $argv[3];
$amount = $argv[4];

$user = $db->entityManager()->find(User::class, $userId);
$trip = $db->entityManager()->find(Trip::class, $tripId);

$transaction = new Transaction();

$transaction->setName($transactionName);
$transaction->setTrip($trip);
$transaction->setUser($user);

$fee = Money::USD($amount);

$transaction->setAmount($fee);
$transaction->setCreated(new DateTime('now'));

$db->persistAndFlush($transaction);

//$trip = $db->entityManager()->find(Trip::class, $tripId);
//dump(count($trip->getTransactions()));

//dump($trip->getId());
//
