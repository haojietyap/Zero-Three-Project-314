<?php
require_once __DIR__ . '/../../../Entities/ManagementProfile.php';

class CreateManagementProfileController {
    public function create($userId, $phone, $address) {
        $profile = new ManagementProfile();
        return $profile->create($userId, $phone, $address);
    }
}

