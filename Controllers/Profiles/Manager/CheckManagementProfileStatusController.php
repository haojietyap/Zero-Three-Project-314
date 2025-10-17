<?php
require_once __DIR__ . '/../../../Entities/ManagementProfile.php';

class CheckManagementProfileStatusController {
    public function getProfileStatus($userId) {
        $profile = new ManagementProfile();

        if (!$profile->exists($userId)) {
            return 'not_created';
        }

        $data = $profile->getProfileByUserId($userId);
        return $data['status'] ?? 'unknown';
    }
}

