<?php
require_once __DIR__ . '/../../../Entities/PINProfile.php';

class SuspendPINProfileController {
    public function suspend($userId) {
        $profile = new PINProfile();
        return $profile->suspendProfile($userId);
    }
}

