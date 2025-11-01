<?php
require_once __DIR__ . '/../../Entities/WeeklyReport.php';

class WeeklyReportController {
    public function getStats() {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->getWeeklyCategoryStats();
    }
}
