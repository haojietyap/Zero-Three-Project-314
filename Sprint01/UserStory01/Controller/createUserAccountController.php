<?php

require_once __DIR__ . '/../Entity/UserAccount.php';

class createUserAccountController
{
    private $userAccount;

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function createUserAccount(
        string $username,
        string $password,
        string $email,
        string $phone,
        int $profile_id
    ): bool {
        if (empty($username) || empty($password) || empty($email)) {
            return false;
        }

        if ($this->userAccount->emailExists($email)) {
            return false;
        }

        return $this->userAccount->createUserAccount(
            $username,
            $password,
            $email,
            $phone,
            $profile_id
        );
    }
}
