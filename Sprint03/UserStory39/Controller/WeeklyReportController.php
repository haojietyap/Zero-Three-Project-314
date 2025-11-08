<?php
require_once __DIR__ . '/../entity/WeeklyReport.php';

class weeklyReportController {
    private report $reportEntity;

    public function __construct() {
        $this->reportEntity = new report();
    }

    public function getReportByWeek(string $startDate, string $endDate): array {
        $totalRequests = $this->reportEntity->countRequestsBetween($startDate, $endDate);
        $totalConfirmed = $this->reportEntity->countConfirmedBetween($startDate, $endDate);

        return [
            'totalRequests' => $totalRequests,
            'totalConfirmed' => $totalConfirmed
        ];
    }
}
?>
