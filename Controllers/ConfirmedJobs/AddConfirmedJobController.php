<?php
require_once __DIR__ . '/../../Entities/ConfirmedJob.php';

class AddConfirmedJobController {
    public function add($jobId, $cleanerId, $homeownerId, $matchedDate) {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->addConfirmedJob($jobId, $cleanerId, $homeownerId, $matchedDate);
    }
}
