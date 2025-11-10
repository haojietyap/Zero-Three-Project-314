<?php

require_once __DIR__ . '/../Entity/UserProfile.php';

class suspendProfileController
{

    private $userProfile;

    public function __construct()
    {
        $this->userProfile = new UserProfile();
    }

    // validate the data and forward the suspend request to the Entity.
    public function suspendUserProfile(int $profile_id): bool
    {
        if ($profile_id <= 0) {
            return false;
        }
        return $this->userProfile->suspendUserProfile($profile_id);
    }
}
