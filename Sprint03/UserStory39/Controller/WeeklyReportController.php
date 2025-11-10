<?php
require_once __DIR__ . '/../Boundary/view_weekly_report.php';
require_once __DIR__ . '/../Entity/WeeklyReport.php';

class WeeklyReportController
{
    private GenerateWeeklyReportBoundary $boundary;
    private Report $reportEntity;

    public function __construct(GenerateWeeklyReportBoundary $boundary)
    {
        $this->boundary = $boundary;
        $this->reportEntity = new Report();
    }

    public function getReportByWeek(): void
    {
        $week = $this->boundary->getSelectedWeek();
        $startDate = $week['startDate'];
        $endDate   = $week['endDate'];

        try {
            $totalRequests  = $this->reportEntity->countRequestsBetween($startDate, $endDate);
            $totalConfirmed = $this->reportEntity->countConfirmedBetween($startDate, $endDate);

            $this->boundary->displayGenerateReport($totalRequests, $totalConfirmed);
        } catch (Exception $e) {
            $this->boundary->displayError($e->getMessage());
        }
    }
}
?>
