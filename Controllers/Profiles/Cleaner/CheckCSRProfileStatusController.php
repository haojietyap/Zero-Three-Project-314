<?php
require_once __DIR__ . '/../../../Entities/CSRProfile.php';

class CheckCSRProfileStatusController {
    public function getProfileStatus($userId) {
		$profile = new CSRProfile();
		
    if (!$profile->exists($userId)) {
        return 'not_created';
    }
	
     $data = $profile->getProfileByUserId($userId);
     return $data['status'] ?? 'unknown';
	}
}


