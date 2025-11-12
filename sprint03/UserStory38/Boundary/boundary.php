<?php
class GenerateDailyReportBoundary {

    // Display the report generation page
    public function displayGenerateReport() {
        echo "<h2>Generate Daily Report</h2>
        <form method='POST'>
            <label for='report_date'>Select Date:</label><br>
            <input type='date' name='report_date' required><br><br>
            <button type='submit' name='generate'>Generate Report</button>
        </form>
        <hr>";
    }

    // Get selected date from form input
    public function getSelectedDate() {
        return $_POST['report_date'] ?? null;
    }

    // Display report results
    public function displayReport($reportData, $date) {
        if (!$reportData) {
            echo "<p style='color:red;'>No data found for $date.</p>";
            return;
        }

        echo "<h3>📅 Daily Report for $date</h3>";
        echo "<table border='1' cellpadding='8' cellspacing='0'>
                <tr><th>Metric</th><th>Count</th></tr>
                <tr><td>Total Requests</td><td>{$reportData['totalRequests']}</td></tr>
                <tr><td>Confirmed Requests</td><td>{$reportData['totalConfirmed']}</td></tr>
              </table>";
    }
}
?>
