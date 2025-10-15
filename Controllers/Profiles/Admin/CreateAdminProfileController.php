<?php
require_once __DIR__ . '/../../../Entities/AdminProfile.php';

class CreateAdminProfileController {
    public function create($userId, $phone, $address) {
        $profile = new AdminProfile();
        return $profile->create($userId, $phone, $address);
    }
}
