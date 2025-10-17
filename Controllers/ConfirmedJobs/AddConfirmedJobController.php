<?php
require_once __DIR__ . '/../../Entities/ConfirmedJob.php';

class AddConfirmedJobController {
    public function add($jobId, $CSRId, $PINId, $matchedDate) {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->addConfirmedJob($jobId, $CSRId, $PINId, $matchedDate);
    }
}

