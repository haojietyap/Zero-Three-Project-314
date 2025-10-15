<?php
require_once __DIR__ . '/../../Entities/CleaningService.php';

class ViewMyCleaningServicesController {
    public function getServicesByCleaner($cleanerId) {
        $cleaningService = new CleaningService();
        return $cleaningService->getServicesByCleaner($cleanerId);
    }
}
