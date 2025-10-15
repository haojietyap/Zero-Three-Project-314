<?php
require_once __DIR__ . '/../../../Entities/ManagerProfile.php';

class CreateManagerProfileController {
    public function create($userId, $phone, $address) {
        $profile = new ManagerProfile();
        return $profile->create($userId, $phone, $address);
    }
}
