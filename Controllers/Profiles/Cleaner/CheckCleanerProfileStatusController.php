<?php
require_once __DIR__ . '/../../../Entities/CleanerProfile.php';

class CheckCleanerProfileStatusController {
    public function getProfileStatus($userId) {
		$profile = new CleanerProfile();
		
    if (!$profile->exists($userId)) {
        return 'not_created';
    }
	
     $data = $profile->getProfileByUserId($userId);
     return $data['status'] ?? 'unknown';
	}
}

