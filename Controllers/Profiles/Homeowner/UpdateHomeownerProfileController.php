<?php
require_once __DIR__ . '/../../../Entities/HomeownerProfile.php';

class UpdateHomeownerProfileController {
    public function updateProfile($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference) {
        $profile = new HomeownerProfile();
        return $profile->updateProfile($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference);
    }
}
