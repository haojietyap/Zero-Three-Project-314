<?php
require_once __DIR__ . '/../../../Entities/HomeownerProfile.php';

class SuspendHomeownerProfileController {
    public function suspend($userId) {
        $profile = new HomeownerProfile();
        return $profile->suspendProfile($userId);
    }
}
