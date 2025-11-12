<?php
require_once __DIR__ . '/../Boundary/boundary.php';
require_once __DIR__ . '/../Entity/entity.php';

class DailyReportController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new GenerateDailyReportBoundary();
        $this->entity = new Report();
    }

    public function getReportByDate() {
        // Step 1: Display report page
        $this->boundary->displayGenerateReport();

        // Step 2: Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
            $date = $this->boundary->getSelectedDate();

            if (!$date) {
                echo "<p style='color:red;'>Please select a date to generate the report.</p>";
                return;
            }

            // Step 3: Fetch counts
            $totalRequests = $this->entity->countRequestsByDate($date);
            $totalConfirmed = $this->entity->countConfirmedByDate($date);

            // Step 4: Prepare result
            $reportData = [
                'totalRequests' => $totalRequests,
                'totalConfirmed' => $totalConfirmed
            ];

            // Step 5: Display report
            $this->boundary->displayReport($reportData, $date);
        }
    }
}
?>
