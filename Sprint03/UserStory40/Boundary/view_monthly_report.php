<?php
require_once __DIR__ . '/../Controller/MonthlyReportController.php';
date_default_timezone_set('Asia/Singapore');

class GenerateMonthlyReportBoundary
{
    private int $year;
    private int $month;

    public function __construct()
    {
        // Default to current year and month
        $this->year  = (int)($_GET['year'] ?? date('Y'));
        $this->month = (int)($_GET['month'] ?? date('m'));
    }

    public function getSelectedMonth(): array
    {
        return [
            'year'  => $this->year,
            'month' => $this->month
        ];
    }

    public function displayGenerateReport(array $reportResult): void
    {
        $year  = $reportResult['year'];
        $month = str_pad($reportResult['month'], 2, '0', STR_PAD_LEFT);
        $totalRequests  = $reportResult['totalRequests'];
        $totalConfirmed = $reportResult['totalConfirmed'];
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Monthly Report</title>
        </head>
        <body>
        <h2>Monthly Report: <?= $year ?>-<?= $month ?></h2>

        <?php if ($totalRequests > 0): ?>
            <p>Total Requests: <?= $totalRequests ?></p>
            <p>Confirmed Requests: <?= $totalConfirmed ?></p>
        <?php else: ?>
            <p>No requests found this month.</p>
        <?php endif; ?>

        <a href="manager_dashboard.php">Back to Dashboard</a>
        </body>
        </html>
        <?php
    }
}
$boundary   = new GenerateMonthlyReportBoundary();
$controller = new MonthlyReportController($boundary);
$reportData = $controller->getReportByMonth();
$boundary->displayGenerateReport($reportData);
?>
