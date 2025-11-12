<?php
require_once __DIR__ . '/../Boundary/boundary.php';
require_once __DIR__ . '/../Entity/entity.php';

class WeeklyReportController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new GenerateWeeklyReportBoundary();
        $this->entity = new Report();
    }

    public function getReportByWeek() {
        // Step 1: Display page
        $this->boundary->displayGenerateReport();

        // Step 2: Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
            $dates = $this->boundary->getSelectedWeek();
            $startDate = $dates['start_date'];
            $endDate = $dates['end_date'];

            if (!$startDate || !$endDate) {
                echo "<p style='color:red;'>Please select both start and end dates.</p>";
                return;
            }

            if ($endDate < $startDate) {
                echo "<p style='color:red;'>End date cannot be earlier than start date.</p>";
                return;
            }

            // Step 3: Fetch data
            $totalRequests = $this->entity->countRequestsBetween($startDate, $endDate);
            $totalConfirmed = $this->entity->countConfirmedBetween($startDate, $endDate);

            // Step 4: Prepare result
            $reportData = [
                'totalRequests' => $totalRequests,
                'totalConfirmed' => $totalConfirmed
            ];

            // Step 5: Display report
            $this->boundary->displayReport($reportData, $startDate, $endDate);
        }
    }
}
?>
