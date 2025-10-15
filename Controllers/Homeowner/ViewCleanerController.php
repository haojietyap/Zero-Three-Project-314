<?php
require_once __DIR__ . '/../../Entities/CleanerProfile.php';

class ViewCleanersController {
    public function getAllActiveCleaners() {
        $cleanerProfile = new CleanerProfile();
        return $cleanerProfile->getAllActiveCleaners();
    }
}
