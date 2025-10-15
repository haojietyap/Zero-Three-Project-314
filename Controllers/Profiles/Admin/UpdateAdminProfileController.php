<?php
require_once __DIR__ . '/../../../Entities/AdminProfile.php';

class UpdateAdminProfileController {
    public function update($userId, $phone, $address) {
        $profile = new AdminProfile();
        return $profile->updateProfile($userId, $phone, $address);
    }
}
