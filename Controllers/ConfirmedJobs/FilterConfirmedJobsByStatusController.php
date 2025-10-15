<?php
require_once __DIR__ . '/../../Entities/ConfirmedJob.php';

class FilterConfirmedJobsByStatusController {
    public function filter($cleanerId, $status) {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->filterJobsByCleanerWithStatus($cleanerId, $status);
    }
}
