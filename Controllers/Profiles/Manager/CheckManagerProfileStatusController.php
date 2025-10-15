<?php
require_once __DIR__ . '/../../../Entities/ManagerProfile.php';

class CheckManagerProfileStatusController {
    public function getProfileStatus($userId) {
        $profile = new ManagerProfile();

        if (!$profile->exists($userId)) {
            return 'not_created';
        }

        $data = $profile->getProfileByUserId($userId);
        return $data['status'] ?? 'unknown';
    }
}
