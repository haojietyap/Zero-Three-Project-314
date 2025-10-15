<?php
require_once __DIR__ . '/../../Entities/ConfirmedJob.php';

class MarkJobCompletedController {
    public function complete($matchId) {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->markAsCompleted($matchId);
    }
}
