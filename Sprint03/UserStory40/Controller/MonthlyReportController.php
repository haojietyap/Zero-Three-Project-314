<?php
require_once __DIR__ . '/../Entity/MonthlyReport.php';
require_once __DIR__ . '/../Boundary/view_monthly_report.php';

class MonthlyReportController
{
    private Report $reportEntity;
    private GenerateMonthlyReportBoundary $boundary;

    public function __construct(GenerateMonthlyReportBoundary $boundary)
    {
        $this->boundary = $boundary;
        $this->reportEntity = new Report();
    }

    public function getReportByMonth(): array
    {
        $selected = $this->boundary->getSelectedMonth();
        $year  = $selected['year'];
        $month = $selected['month'];

        $totalRequests  = $this->reportEntity->countRequestsInMonth($year, $month);
        $totalConfirmed = $this->reportEntity->countConfirmedInMonth($year, $month);

        return [
            'year' => $year,
            'month' => $month,
            'totalRequests' => $totalRequests,
            'totalConfirmed' => $totalConfirmed
        ];
    }
}
?>