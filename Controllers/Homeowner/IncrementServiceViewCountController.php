<?php
require_once __DIR__ . '/../../Entities/ConsultationService.php';

class IncrementServiceViewCountController {
    public function increment($jobId, $PINId) {
        $consultationService = new ConsultationService();
        return $consultationService->incrementViewCountIfNew($jobId, $PINId);
    }
}
?>

