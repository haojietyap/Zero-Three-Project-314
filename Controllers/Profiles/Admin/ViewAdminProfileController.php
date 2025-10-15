<?php
require_once __DIR__ . '/../../../Entities/AdminProfile.php';

class ViewAdminProfileController {
    public function getProfileByUserId($userId) {
        $profile = new AdminProfile();
        return $profile->getProfileByUserId($userId);
    }
}
