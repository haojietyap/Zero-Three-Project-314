<?php
require_once __DIR__ . '/../Boundary/view_daily_report.php';
require_once __DIR__ . '/../Entity/DailyReport.php';

class DailyReportController
{
    private GenerateDailyReportBoundary $boundary;

    public function __construct(GenerateDailyReportBoundary $boundary)
    {
        $this->boundary = $boundary;
    }

    public function getReportByDate(): void
    {
        $date = $this->boundary->getSelectedDate();

        if (!$date) {
            $this->boundary->renderError("Invalid date selected.");
            return;
        }

        $totalRequests  = Report::countRequestsByDate($date);
        $totalConfirmed = Report::countConfirmedByDate($date);

        if ($totalRequests === 0 && $totalConfirmed === 0) {
            $this->boundary->renderEmpty();
        } else {
            $this->boundary->renderReport($totalRequests, $totalConfirmed, $date);
        }
    }
}
?>