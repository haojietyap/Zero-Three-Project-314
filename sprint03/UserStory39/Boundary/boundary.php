<?php
class GenerateWeeklyReportBoundary {

    // Display report generation page
    public function displayGenerateReport() {
        echo "<h2>Generate Weekly Report</h2>
        <form method='POST'>
            <label for='start_date'>Start Date:</label><br>
            <input type='date' name='start_date' required><br><br>
            <label for='end_date'>End Date:</label><br>
            <input type='date' name='end_date' required><br><br>
            <button type='submit' name='generate'>Generate Report</button>
        </form>
        <hr>";
    }

    // Get selected week range from form
    public function getSelectedWeek() {
        return [
            'start_date' => $_POST['start_date'] ?? null,
            'end_date' => $_POST['end_date'] ?? null
        ];
    }

    // Display report results
    public function displayReport($reportData, $startDate, $endDate) {
        if (!$reportData) {
            echo "<p style='color:red;'>No data found between $startDate and $endDate.</p>";
            return;
        }

        echo "<h3>📅 Weekly Report ($startDate → $endDate)</h3>";
        echo "<table border='1' cellpadding='8' cellspacing='0'>
                <tr><th>Metric</th><th>Count</th></tr>
                <tr><td>Total Requests</td><td>{$reportData['totalRequests']}</td></tr>
                <tr><td>Confirmed Requests</td><td>{$reportData['totalConfirmed']}</td></tr>
              </table>";
    }
}
?>
