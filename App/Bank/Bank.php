<?php
namespace App\Bank;

use App\Accounts\MultiCurrencyAccount;

class Bank {
    // bank account
    private MultiCurrencyAccount $account;

    /**
     * Creates new currency account
     * @return MultiCurrencyAccount
     */
    public function createNewCurrencyAccount(): MultiCurrencyAccount {
        return $this->account = new MultiCurrencyAccount();
    }

    /**
     * Returns bank account
     * @return MultiCurrencyAccount
     */
    public function getAccount(): MultiCurrencyAccount {
        return $this->account;
    }
}
