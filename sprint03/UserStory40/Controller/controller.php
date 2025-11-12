<?php
require_once __DIR__ . '/../Boundary/boundary.php';
require_once __DIR__ . '/../Entity/entity.php';

class MonthlyReportController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new GenerateMonthlyReportBoundary();
        $this->entity = new Report();
    }

    public function getReportByMonth() {
        // Step 1: Display the selection form
        $this->boundary->displayGenerateReport();

        // Step 2: Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
            $selection = $this->boundary->getSelectedMonth();
            $year = $selection['year'];
            $month = $selection['month'];

            if (!$year || !$month) {
                echo "<p style='color:red;'>Please select both year and month.</p>";
                return;
            }

            // Step 3: Retrieve report data
            $totalRequests = $this->entity->countRequestsInMonth($year, $month);
            $totalConfirmed = $this->entity->countConfirmedInMonth($year, $month);

            // Step 4: Prepare results
            $reportData = [
                'totalRequests' => $totalRequests,
                'totalConfirmed' => $totalConfirmed
            ];

            // Step 5: Display report
            $this->boundary->displayReport($reportData, $year, $month);
        }
    }
}
?>
