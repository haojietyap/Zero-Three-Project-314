<?php
require_once __DIR__ . '/../../../Entities/ManagerProfile.php';

class SuspendManagerProfileController {
    public function suspend($userId) {
        $profile = new ManagerProfile();
        return $profile->suspendProfile($userId);
    }
}
