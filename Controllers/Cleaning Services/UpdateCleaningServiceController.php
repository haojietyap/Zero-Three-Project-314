<?php
require_once __DIR__ . '/../../Entities/CleaningService.php';

class UpdateCleaningServiceController {
    public function getServiceById($jobId) {
        $cleaningService = new CleaningService();
        return $cleaningService->getServiceById($jobId);
    }

    public function updateService($jobId, $title, $description, $categoryId, $price) {
        $cleaningService = new CleaningService();
        return $cleaningService->updateService($jobId, $title, $description, $categoryId, $price);
    }
}
