<?php
require_once __DIR__ . '/../../Entities/ConfirmedJob.php';

class DailyReportController {
    public function getTodayCount() {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->countConfirmedToday();
    }
}
