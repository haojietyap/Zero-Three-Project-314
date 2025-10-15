<?php
require_once __DIR__ .'/../../../Entities/CleanerProfile.php';

class ViewCleanerProfileController {
    public function getProfile($userId) {
        $cleanerProfile = new CleanerProfile();
        return $cleanerProfile->getCleanerProfileByUserId($userId);
    }
}
