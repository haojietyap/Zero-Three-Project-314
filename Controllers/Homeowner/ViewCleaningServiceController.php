<?php
require_once __DIR__ . '/../../Entities/CleaningService.php';

class ViewCleaningServiceController {
    public function getServiceById($jobId) {
		$cleaningService = new CleaningService();
		return $cleaningService->getServiceById($jobId);
	}

}
