<?php
require_once __DIR__ . '/../../../Entities/AdminProfile.php';

class SuspendAdminProfileController {
    public function suspend($userId) {
        $profile = new AdminProfile();
        return $profile->suspendProfile($userId);
    }
}
