<?php

require_once __DIR__ . '/../Entity/UserProfile.php';

class viewProfileController
{
    private $userProfile;

    public function __construct()
    {
        $this->userProfile = new UserProfile();
    }

    public function viewUserProfiles(): array
    {
        return $this->userProfile->viewUserProfiles();
    }
}
