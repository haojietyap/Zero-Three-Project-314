<?php
require_once __DIR__ .'/../../../Entities/CSRProfile.php';

class CreateCSRProfileController {
    public function createProfile($userId, $phone, $address, $experience, $preferredConsultationTime, $consultationFrequency, 
								  $languagePreference, $expertise, $rating) {
        $cleanerProfile = new CSRProfile();

        if (!$CSRProfile->exists($userId)) {
            return $CSRProfile->createProfile(
                $userId,
                $phone,
                $address,
                $experience,
                $preferredConsultationTime,
                $consultationFrequency,
                $languagePreference,
                $expertise,
                $rating
            );
        }

        return false; 
    }
}


