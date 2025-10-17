<?php
require_once __DIR__ . '/../../../Entities/PINProfile.php';

class CheckPINProfileStatusController {
    public function getProfileStatus($userId) {
        $profile = new PINProfile();

        if (!$profile->exists($userId)) {
            return 'not_created';
        }

        $data = $profile->getProfileByUserId($userId);
        return $data['status'] ?? 'unknown';
    }
}

