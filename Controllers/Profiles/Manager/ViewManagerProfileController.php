<?php
require_once __DIR__ . '/../../../Entities/ManagerProfile.php';

class ViewManagerProfileController {
    public function getProfileByUserId($userId) {
        $profile = new ManagerProfile();
        return $profile->getProfileByUserId($userId);
    }
}
