<?php
require_once __DIR__ . '/../../Entities/ConsultationService.php';

class SearchMyConsultationServicesController {
    public function searchServicesByTitle($CSRId, $keyword) {
        $consultationService = new ConsultationService();
        return $consultationService->searchServicesByTitle($CSRId, $keyword);
    }
}
?>

