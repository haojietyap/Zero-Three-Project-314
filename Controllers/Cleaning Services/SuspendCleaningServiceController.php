<?php
require_once __DIR__ . '/../../Entities/CleaningService.php';

class SuspendCleaningServiceController
{
    public function suspend($jobId)
    {
        $cleaningService = new CleaningService();
        return $cleaningService->suspendService($jobId);
    }
}
