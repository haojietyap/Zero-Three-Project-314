<?php
require_once __DIR__ .'/../../../Entities/CleanerProfile.php';

class CreateCleanerProfileController {
    public function createProfile($userId, $phone, $address, $experience, $preferredCleaningTime, $cleaningFrequency, 
								  $languagePreference, $expertise, $rating) {
        $cleanerProfile = new CleanerProfile();

        if (!$cleanerProfile->exists($userId)) {
            return $cleanerProfile->createProfile(
                $userId,
                $phone,
                $address,
                $experience,
                $preferredCleaningTime,
                $cleaningFrequency,
                $languagePreference,
                $expertise,
                $rating
            );
        }

        return false; 
    }
}

