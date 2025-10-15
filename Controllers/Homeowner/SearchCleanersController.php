<?php
require_once __DIR__ . '/../../Entities/CleanerProfile.php';

class SearchCleanersController {
    public function searchByCategoryOrRating($keyword) {
        $cleanerProfile = new CleanerProfile();
        return $cleanerProfile->searchCleanersByCategoryOrRating($keyword);
    }
}
