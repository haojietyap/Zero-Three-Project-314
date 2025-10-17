<?php
require_once __DIR__ . '/../../../Entities/ManagementProfile.php';

class SuspendManagementProfileController {
    public function suspend($userId) {
        $profile = new ManagementProfile();
        return $profile->suspendProfile($userId);
    }
}

