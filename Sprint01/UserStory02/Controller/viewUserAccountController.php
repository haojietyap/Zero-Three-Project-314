<?php

require_once __DIR__ . '/../Entity/UserAccount.php';

class viewUserAccountController
{

    private $userAccount;

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function viewUserAccountData(): array
    {
        return $this->userAccount->viewUserAccountData();
    }
}
