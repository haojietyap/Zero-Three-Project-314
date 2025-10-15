<?php
require_once __DIR__ . '/../../../Entities/HomeownerProfile.php';

class CheckHomeownerProfileStatusController {
    public function getProfileStatus($userId) {
        $profile = new HomeownerProfile();

        if (!$profile->exists($userId)) {
            return 'not_created';
        }

        $data = $profile->getProfileByUserId($userId);
        return $data['status'] ?? 'unknown';
    }
}
