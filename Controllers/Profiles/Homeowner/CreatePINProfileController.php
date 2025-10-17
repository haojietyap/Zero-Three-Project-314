<?php
require_once __DIR__ . '/../../../Entities/PINProfile.php';

class CreatePINProfileController {
    public function createProfile($userId, $phone, $address, $preferredConsultationTime, $consultationFrequency, $languagePreference) {
        $profile = new PINProfile();

        if (!$profile->exists($userId)) {
            return $profile->create($userId, $phone, $address, $preferredConsultationTime, $consultationFrequency, $languagePreference);
        }

        return false;
    }
}

