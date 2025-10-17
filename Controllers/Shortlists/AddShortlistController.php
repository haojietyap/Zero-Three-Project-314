<?php
require_once __DIR__ . '/../../Entities/Shortlists.php';

class AddShortlistController {
    public function add($PINId, $jobId) {
        $shortlists = new Shortlists($conn);
        return $shortlists->addToShortlist($PINId, $jobId);
    }
}

