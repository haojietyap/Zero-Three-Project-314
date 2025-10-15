<?php
require_once __DIR__ . '/../../Entities/CleanerProfile.php';

class GetCleanerProfileByUserIdController {
    public function getProfileByUserId($userId) {
        $cleanerProfile = new CleanerProfile();
        return $cleanerProfile->getCleanerProfileByUserId($userId);
    }
}
