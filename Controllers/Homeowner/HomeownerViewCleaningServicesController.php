<?php
require_once __DIR__ . '/../../Entities/CleaningService.php';

class HomeownerViewCleaningServicesController {
    public function getOfferedServicesByCleaner($cleanerId) {
        $cleaningService = new CleaningService();
        return $cleaningService->getOfferedServicesByCleaner($cleanerId);
    }
}