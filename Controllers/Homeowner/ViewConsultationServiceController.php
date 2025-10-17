<?php
require_once __DIR__ . '/../../Entities/ConsultationService.php';

class ViewConsultationServiceController {
    public function getServiceById($jobId) {
		$consultationService = new ConsultationService();
		return $consultationService->getServiceById($jobId);
	}

}

