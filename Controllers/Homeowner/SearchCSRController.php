<?php
require_once __DIR__ . '/../../Entities/CSRProfile.php';

class SearchCSRController {
    public function searchByCategoryOrRating($keyword) {
        $CSRProfile = new CSRProfile();
        return $CSRProfile->searchCSRByCategoryOrRating($keyword);
    }
}

