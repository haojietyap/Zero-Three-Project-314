<?php
require_once __DIR__ .'/../../../Entities/CleanerProfile.php';

class UpdateCleanerProfileController {
    public function updateProfile($userId, $phone, $address, $experience, $preferredCleaningTime, $cleaningFrequency, 
								  $languagePreference, $expertise, $rating) {
									  
        $cleanerProfile = new CleanerProfile();
        return $cleanerProfile->updateCleanerProfile($userId, $phone, $address, $experience, $preferredCleaningTime, $cleaningFrequency, $languagePreference, $expertise, $rating);
    }
	
	public function getCleanerProfileByUserId($userId) {
        $cleanerProfile = new CleanerProfile();
        return $cleanerProfile->getCleanerProfileByUserId($userId);
    }
}
