<?php
require_once __DIR__ . '/../../Entities/CleaningService.php';

class SearchMyCleaningServicesController {
    public function searchServicesByTitle($cleanerId, $keyword) {
        $cleaningService = new CleaningService();
        return $cleaningService->searchServicesByTitle($cleanerId, $keyword);
    }
}
?>
