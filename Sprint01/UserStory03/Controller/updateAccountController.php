<?php

require_once __DIR__ . '/../Entity/UserAccount.php';

class updateAccountController
{

    private $userAccount;

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function updateUserAccount(string $email, string $field, string $newValue): bool
    {
        if (empty($email) || empty($field) || $newValue === '') {
            return false;
        }
        return $this->userAccount->updateUserAccount($email, $field, $newValue);
    }
}
