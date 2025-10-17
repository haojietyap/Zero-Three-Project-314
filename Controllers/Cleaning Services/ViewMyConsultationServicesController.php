<?php
require_once __DIR__ . '/../../Entities/ConsultationService.php';

class ViewMyConsultationServicesController {
    public function getServicesByCleaner($CSRId) {
        $consultationService = new ConsultationService();
        return $consultationService->getServicesByCSR($CSRId);
    }
}

