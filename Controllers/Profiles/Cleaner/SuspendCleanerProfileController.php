<?php
require_once __DIR__ . '/../../../Entities/CleanerProfile.php';

class SuspendCleanerProfileController {
    public function suspend($userId) {
        $profile = new CleanerProfile();
        return $profile->suspendProfile($userId);
    }
}
