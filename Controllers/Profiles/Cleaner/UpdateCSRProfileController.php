<?php
require_once __DIR__ .'/../../../Entities/CSRProfile.php';

class UpdateCSRProfileController {
    public function updateProfile($userId, $phone, $address, $experience, $preferredConsultationTime, $consultationFrequency, 
								  $languagePreference, $expertise, $rating) {
									  
        $consultationProfile = new ConsultationProfile();
        return $CSRProfile->updateCSRProfile($userId, $phone, $address, $experience, $preferredConsultationTime, $consultationFrequency, $languagePreference, $expertise, $rating);
    }
	
	public function getCSRProfileByUserId($userId) {
        $CSRProfile = new CSRProfile();
        return $CSRProfile->getCSRProfileByUserId($userId);
    }
}

