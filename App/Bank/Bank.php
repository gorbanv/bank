<?php
namespace App\Bank;

use App\Accounts\MultiCurrencyAccount;

class Bank {
    private MultiCurrencyAccount $account;

    public function createNewCurrencyAccount() {
        return $account = new MultiCurrencyAccount();
    }

    public function getAccount() {
        return $this->account;
    }

}