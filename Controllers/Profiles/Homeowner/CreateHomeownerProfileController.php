<?php
require_once __DIR__ . '/../../../Entities/HomeownerProfile.php';

class CreateHomeownerProfileController {
    public function createProfile($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference) {
        $profile = new HomeownerProfile();

        if (!$profile->exists($userId)) {
            return $profile->create($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference);
        }

        return false;
    }
}
