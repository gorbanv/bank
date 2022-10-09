<?php
namespace App;

require_once('vendor/autoload.php');

use App\Bank\Bank;
use App\Currency\{Rub, Eur, Usd, CurrencyData};

$bank = New Bank();

// Step 1
echo "Step 1\n";
$account = $bank->createNewCurrencyAccount();
$account->addCurrency('RUB');
$account->addCurrency('EUR');
$account->addCurrency('USD');
$account->setDefaultCurrency('RUB');
$account->deposit(new RUB(1000));
$account->deposit(new EUR(50));
$account->deposit(new USD(50));

// Step 2
echo "Step 2\n";
echo $account->getBalance() . PHP_EOL;
echo $account->getBalance('USD') . PHP_EOL;
echo $account->getBalance('EUR') . PHP_EOL;

// Step 3
echo "Step 3\n";
$account->deposit(new RUB(1000));
$account->deposit(new EUR(50));
$account->withdraw(new USD(10));

// Step 4
echo "Step 4\n";
Eur::setExchangeRate('RUB', 150);
Usd::setExchangeRate('RUB', 100);

// Step 5
echo "Step 5\n";
echo $account->getBalance() . PHP_EOL;

// Step 6
echo "Step 6\n";
$account->setDefaultCurrency('EUR');
echo $account->getBalance() . PHP_EOL;

// Step 7
echo "Step 7\n";
$cash = $account->withdraw(new RUB(1000));
$account->deposit(new EUR($cash));

echo "Step 8\n";
Eur::setExchangeRate('RUB', 120);

echo "Step 9\n";
echo $account->getBalance() . PHP_EOL;

echo "Step 10\n";
$account->setDefaultCurrency('RUB');
