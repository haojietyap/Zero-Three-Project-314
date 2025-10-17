<?php
require_once __DIR__ . '/../../Entities/ConsultationService.php';

class UpdateConsultationServiceController {
    public function getServiceById($jobId) {
        $consultationService = new ConsultationService();
        return $consultationService->getServiceById($jobId);
    }

    public function updateService($jobId, $title, $description, $categoryId, $price) {
        $consultationService = new ConsultationService();
        return $consultationService->updateService($jobId, $title, $description, $categoryId, $price);
    }
}

