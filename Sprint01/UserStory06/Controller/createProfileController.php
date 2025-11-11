<?php

require_once __DIR__ . '/../Entity/UserProfile.php';

class createProfileController
{
    private $userProfile;

    public function __construct()
    {
        $this->userProfile = new UserProfile();
    }

    public function createUserProfile(string $profile_name, string $description): bool
    {
        if (empty($profile_name)) {
            return false;
        }
        return $this->userProfile->createUserProfile($profile_name, $description);
    }
}
