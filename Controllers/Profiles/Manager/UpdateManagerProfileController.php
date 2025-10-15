<?php
require_once __DIR__ . '/../../../Entities/ManagerProfile.php';

class UpdateManagerProfileController {
    public function update($userId, $phone, $address) {
        $profile = new ManagerProfile();
        return $profile->updateProfile($userId, $phone, $address);
    }
}
