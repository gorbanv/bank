<?php
namespace App\Bank;

use App\Accounts\MultiCurrencyAccount;

class Bank {
    private MultiCurrencyAccount $account;

    public function createNewCurrencyAccount(): MultiCurrencyAccount {
        return $account = new MultiCurrencyAccount();
    }

    public function getAccount(): MultiCurrencyAccount {
        return $this->account;
    }
}