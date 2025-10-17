<?php
require_once __DIR__ . '/../../../Entities/PINProfile.php';

class ViewPINProfileController {
    public function getProfileByUserId($userId) {
        $profile = new PINProfile();
        return $profile->getProfileByUserId($userId);
    }
}

