<?php
class GenerateMonthlyReportBoundary {

    // Display month selection page
    public function displayGenerateReport() {
        echo "<h2>Generate Monthly Report</h2>
        <form method='POST'>
            <label for='year'>Select Year:</label><br>
            <input type='number' name='year' min='2000' max='2100' required><br><br>
            <label for='month'>Select Month:</label><br>
            <select name='month' required>
                <option value=''>--Select Month--</option>
                <option value='1'>January</option>
                <option value='2'>February</option>
                <option value='3'>March</option>
                <option value='4'>April</option>
                <option value='5'>May</option>
                <option value='6'>June</option>
                <option value='7'>July</option>
                <option value='8'>August</option>
                <option value='9'>September</option>
                <option value='10'>October</option>
                <option value='11'>November</option>
                <option value='12'>December</option>
            </select><br><br>
            <button type='submit' name='generate'>Generate Report</button>
        </form>
        <hr>";
    }

    // Get selected month and year
    public function getSelectedMonth() {
        return [
            'year' => $_POST['year'] ?? null,
            'month' => $_POST['month'] ?? null
        ];
    }

    // Display report output
    public function displayReport($reportData, $year, $month) {
        if (!$reportData) {
            echo "<p style='color:red;'>No data found for $month/$year.</p>";
            return;
        }

        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        echo "<h3>📅 Monthly Report for $monthName $year</h3>";
        echo "<table border='1' cellpadding='8' cellspacing='0'>
                <tr><th>Metric</th><th>Count</th></tr>
                <tr><td>Total Requests</td><td>{$reportData['totalRequests']}</td></tr>
                <tr><td>Confirmed Requests</td><td>{$reportData['totalConfirmed']}</td></tr>
              </table>";
    }
}
?>
