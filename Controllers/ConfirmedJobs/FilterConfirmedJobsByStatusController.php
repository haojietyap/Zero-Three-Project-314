<?php
require_once __DIR__ . '/../../Entities/ConfirmedJob.php';

class FilterConfirmedJobsByStatusController {
    public function filter($CSRId, $status) {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->filterJobsByCSRWithStatus($CSRId, $status);
    }
}

