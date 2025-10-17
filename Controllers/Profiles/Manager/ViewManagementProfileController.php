<?php
require_once __DIR__ . '/../../../Entities/ManagementProfile.php';

class ViewManagementProfileController {
    public function getProfileByUserId($userId) {
        $profile = new ManagementProfile();
        return $profile->getProfileByUserId($userId);
    }
}

