<?php
require_once __DIR__ . '/../../Entities/CleaningService.php';

class CreateCleaningServiceController {
    public function createService($cleanerId, $title, $description, $categoryId, $price) {
        $cleaningService = new CleaningService();
        return $cleaningService->createService($cleanerId, $title, $description, $categoryId, $price);
    }
}
?>
