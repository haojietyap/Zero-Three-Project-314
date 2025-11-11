<?php

require_once __DIR__ . '/../Entity/UserProfile.php';

class searchProfileController
{

    private $userProfile;

    public function __construct()
    {
        $this->userProfile = new UserProfile();
    }


    // validate the search term and delegate to the Entity.
    // returns an array of results (possibly empty).

    public function searchUserProfile(string $profile_name): array
    {
        $profile_name = trim($profile_name);
        if ($profile_name === '') {
            return [];
        }
        return $this->userProfile->searchUserProfile($profile_name);
    }
}
