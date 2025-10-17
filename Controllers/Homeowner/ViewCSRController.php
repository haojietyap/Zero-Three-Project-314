<?php
require_once __DIR__ . '/../../Entities/CSRProfile.php';

class ViewCSRController {
    public function getAllActiveCSR() {
        $CSRProfile = new CSRProfile();
        return $CSRProfile->getAllActiveCSR();
    }
}

