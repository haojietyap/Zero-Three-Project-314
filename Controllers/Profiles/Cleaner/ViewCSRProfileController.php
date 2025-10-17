<?php
require_once __DIR__ .'/../../../Entities/CSRProfile.php';

class ViewCSRProfileController {
    public function getProfile($userId) {
        $CSRProfile = new CSRProfile();
        return $CSRProfile->getCSRProfileByUserId($userId);
    }
}

