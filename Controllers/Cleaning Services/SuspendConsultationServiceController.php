<?php
require_once __DIR__ . '/../../Entities/ConsultationService.php';

class SuspendConsultationServiceController
{
    public function suspend($jobId)
    {
        $consultationService = new ConsultationService();
        return $consultationService->suspendService($jobId);
    }
}

