<?php
require_once __DIR__ . '/../entity/MonthlyReport.php';

class monthlyReportController {
    private report $reportEntity;

    public function __construct() {
        $this->reportEntity = new report();
    }

    public function getReportByMonth(int $year, int $month): array {
        $totalRequests = $this->reportEntity->countRequestsInMonth($year, $month);
        $totalConfirmed = $this->reportEntity->countConfirmedInMonth($year, $month);

        return [
            'totalRequests' => $totalRequests,
            'totalConfirmed' => $totalConfirmed
        ];
    }
}
?>
