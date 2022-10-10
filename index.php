<?php
namespace App;

require_once('vendor/autoload.php');

use App\Bank\Bank;
use App\Accounts\MultiCurrencyAccount;
use App\Currency\Currencies\{Rub, Eur, Usd};
use App\Currency\CurrencyData;

$bank = New Bank();

// Step 1
// Клиент открывает мультивалютный счет, включающий сбережения в 3-х валютах с
// основной валютой российский рубль, и пополняет его следующими суммами: 1000
echo "Step 1\n";
$account = $bank->createNewCurrencyAccount();
$account->addCurrency('RUB');
$account->addCurrency('EUR');
$account->addCurrency('USD');
$account->setDefaultCurrency('RUB');
print_r($account->getSuppliedCurrency());
$account->deposit(new RUB(1000));
$account->deposit(new EUR(50));
$account->deposit(new USD(50));

// Step 2
// Клиент хочет увидеть суммарный баланс счета в основной валюте, либо в валюте на
// выбор.
echo "Step 2\n";
echo $account->getBalance() . " RUB\n";
echo $account->getBalance('USD') . " USD\n";
echo $account->getBalance('EUR') . " EUR\n";

// Step 3
// Клиент совершает операции пополнения/списания со счета.
echo "Step 3\n";
$account->deposit(new RUB(1000));
$account->deposit(new EUR(50));
$account->withdraw(new USD(10));

// Step 4
// Банк меняет курс валюты для EUR и USD по отношению к рублю на 150 и 100
// соответственно
echo "Step 4\n";
Eur::setExchangeRate('RUB', 150);
Usd::setExchangeRate('RUB', 100);

// Step 5
// Клиент хочет увидеть суммарный баланс счета в рублях, после изменения курса
// валют.
echo "Step 5\n";
echo $account->getBalance() . " EUR\n";

// Step 6
// После этого клиент решает изменить основную валюту счета на EUR, и запрашивает
// текущий баланс
echo "Step 6\n";
$account->setDefaultCurrency('EUR');
echo $account->getBalance() . " EUR\n";

// Step 7
// Чтобы избежать дальнего ослабления рубля клиент решает сконвертировать
// рублевую часть счета в EUR, и запрашивает баланс
echo "Step 7\n";
$cash = $account->withdraw(new RUB(1000));
$account->deposit(new EUR($cash));
echo $account->getBalance('EUR') . " EUR\n";

// Step 8
// Банк меняет курс валюты для EUR к RUB на 120
echo "Step 8\n";
Eur::setExchangeRate('RUB', 120);

// Step 9
// После изменения курса клиент проверяет, что баланс его счета не изменился
echo "Step 9\n";
echo $account->getBalance() . " EUR\n";

// Step 10
// Банк решает, что не может больше поддерживать обслуживание следующих валют
// EUR и USD. Согласовывает с клиентом изменение основной валюты счета на RUB, с
// конвертацией балансов неподдерживаемых валют.
echo "Step 10\n";
$account->setDefaultCurrency('RUB');
$account->removeAccount('EUR');
$account->removeAccount('USD');
print_r($account->getSuppliedCurrency());
echo $account->getBalance() . " RUB\n";
