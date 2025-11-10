<?php


require_once __DIR__ . '/../Entity/UserAccount.php';

class LoginController
{

    private $userAccount;

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }




    // returns true if email, password and profile_id represent a valid active user.

    public function validateAccount(string $email, string $password, int $profile_id): bool
    {
        $email = trim($email);
        $password = trim($password);

        if ($email === '' || $password === '' || $profile_id <= 0) {
            return false;
        }

        return $this->userAccount->validateAccount($email, $password, $profile_id);
    }
}
