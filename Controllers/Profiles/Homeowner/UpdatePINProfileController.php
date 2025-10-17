<?php
require_once __DIR__ . '/../../../Entities/PINProfile.php';

class UpdatePINProfileController {
    public function updateProfile($userId, $phone, $address, $preferredConsultationTime, $consultationFrequency, $languagePreference) {
        $profile = new PINProfile();
        return $profile->updateProfile($userId, $phone, $address, $preferredConsultationTime, $consultationFrequency, $languagePreference);
    }
}

