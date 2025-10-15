<?php
require_once __DIR__ . '/../../Entities/ConfirmedJob.php';

class CountCompletedByServiceController {
    public function getStats($cleanerId) {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->countCompletedByService($cleanerId);
    }
}
