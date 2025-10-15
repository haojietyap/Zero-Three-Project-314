<?php
require_once __DIR__ . '/../../Entities/ConfirmedJob.php';

class WeeklyReportController {
    public function getStats() {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->getWeeklyCategoryStats();
    }
}
