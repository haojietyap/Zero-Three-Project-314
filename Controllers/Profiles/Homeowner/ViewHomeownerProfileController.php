<?php
require_once __DIR__ . '/../../../Entities/HomeownerProfile.php';

class ViewHomeownerProfileController {
    public function getProfileByUserId($userId) {
        $profile = new HomeownerProfile();
        return $profile->getProfileByUserId($userId);
    }
}
