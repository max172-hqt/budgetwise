<?php

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . 'src/Utilities/functions.php';

require base_path('/vendor/autoload.php');

//$a = new Money(7501, new Currency('USD'));
//$b = Money::USD(500);
//
//
//dump($a->divide(2));
//dump($b->absolute());
//
//$money = new Money(7501, new Currency('USD'));
//$currencies = new ISOCurrencies();
//
//$numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
//$moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);
//
//echo $moneyFormatter->format($money);

$a = new Money('75.01', new Currency('USD'));
