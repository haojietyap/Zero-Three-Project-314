<?php

require_once __DIR__ . '/../Entity/UserProfile.php';

class updateProfileController
{

    private $userProfile;

    public function __construct()
    {
        $this->userProfile = new UserProfile();
    }


    // validate the data and forward the update to the Entity.

    public function updateUserProfile(int $profile_id, string $profile_name, string $description): bool
    {
        if ($profile_id <= 0) {
            return false;
        }
        if (empty(trim($profile_name))) {
            return false;
        }

        return $this->userProfile->updateUserProfile($profile_id, $profile_name, $description);
    }
}
