<?php
require_once __DIR__ . '/../../../Entities/AdminProfile.php';

class CheckAdminProfileStatusController {
    public function getProfileStatus($userId) {
        $profile = new AdminProfile();

        if (!$profile->exists($userId)) {
            return 'not_created';
        }

        $data = $profile->getProfileByUserId($userId);
        return $data['status'] ?? 'unknown';
    }
}
