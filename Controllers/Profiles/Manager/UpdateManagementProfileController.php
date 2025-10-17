<?php
require_once __DIR__ . '/../../../Entities/ManagementProfile.php';

class UpdateManagementProfileController {
    public function update($userId, $phone, $address) {
        $profile = new ManagementProfile();
        return $profile->updateProfile($userId, $phone, $address);
    }
}

