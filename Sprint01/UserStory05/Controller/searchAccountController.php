<?php

require_once __DIR__ . '/../Entity/UserAccount.php';

class searchAccountController
{

    private $userAccount;

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function searchUserAccount(string $email): ?array
    {
        if (empty($email)) {
            return null;
        }
        return $this->userAccount->searchUserAccount($email);
    }
}
