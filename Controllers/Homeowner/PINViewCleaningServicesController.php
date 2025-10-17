<?php
require_once __DIR__ . '/../../Entities/ConsultationService.php';

class PINViewCSRServicesController {
    public function getOfferedServicesByCSR($CSRId) {
        $consultationService = new ConsultationService();
        return $consultationService->getOfferedServicesByCSR($CSRId);
    }

}
