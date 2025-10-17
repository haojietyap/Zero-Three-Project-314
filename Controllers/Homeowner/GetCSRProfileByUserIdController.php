<?php
require_once __DIR__ . '/../../Entities/CSRProfile.php';

class GetCSRProfileByUserIdController {
    public function getProfileByUserId($userId) {
        $CSRProfile = new CSRProfile();
        return $CSRProfile->getCSRProfileByUserId($userId);
    }
}

