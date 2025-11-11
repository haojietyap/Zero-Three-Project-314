<?php
require_once __DIR__ . '/../Entity/UserAccount.php';

class createUserAccountController
{
    private UserAccount $userAccount;

    // allow injecting a mock UserAccount for testing
    public function __construct(?UserAccount $userAccount = null)
    {
        $this->userAccount = $userAccount ?? new UserAccount();
    }

    public function createUserAccount(
        string $username,
        string $password,
        string $email,
        string $phone,
        int $profile_id
    ): bool {
        // basic validation: required fields
        if (empty($username) || empty($password) || empty($email)) {
            return false;
        }

        // email must be unique
        if ($this->userAccount->emailExists($email)) {
            return false;
        }

        // delegates to Entity and return its bool
        return $this->userAccount->createUserAccount(
            $username,
            $password,
            $email,
            $phone,
            $profile_id
        );
    }
}
