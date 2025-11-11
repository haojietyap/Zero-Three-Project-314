<?php

require_once __DIR__ . '/../Entity/UserAccount.php';

class suspendAccountController
{
    private $userAccount;

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function suspendUserAccount(string $email): bool
    {
        if (empty($email)) {
            return false;
        }
        return $this->userAccount->suspendUserAccount($email);
    }
}
