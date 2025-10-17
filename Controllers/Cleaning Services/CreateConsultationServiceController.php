<?php
require_once __DIR__ . '/../../Entities/ConsultationService.php';

class CreateConsultationServiceController {
    public function createService($CSRId, $title, $description, $categoryId, $price) {
        $consultationService = new ConsultationService();
        return $consultationService->createService($CSRId, $title, $description, $categoryId, $price);
    }
}
?>

