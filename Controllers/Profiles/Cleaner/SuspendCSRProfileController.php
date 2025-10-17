<?php
require_once __DIR__ . '/../../../Entities/CSRProfile.php';

class SuspendCSRProfileController {
    public function suspend($userId) {
        $profile = new CSRProfile();
        return $profile->suspendProfile($userId);
    }
}

