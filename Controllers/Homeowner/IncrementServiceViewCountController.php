<?php
require_once __DIR__ . '/../../Entities/CleaningService.php';

class IncrementServiceViewCountController {
    public function increment($jobId, $homeownerId) {
        $cleaningService = new CleaningService();
        return $cleaningService->incrementViewCountIfNew($jobId, $homeownerId);
    }
}
?>
