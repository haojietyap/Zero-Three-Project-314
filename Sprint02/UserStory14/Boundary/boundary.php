<?php
class ViewMyRequestsBoundary {

    // Display all requests for the PIN user
    public function viewAllRequests($requests) {
        echo "<h2>My Created Requests</h2>";

        if (empty($requests)) {
            echo "<p style='color:red;'>No Requests Available</p>";
            return;
        }

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr><th>ID</th><th>Category</th><th>Title</th><th>Description</th><th>Location</th><th>Date</th><th>Status</th></tr>";

        foreach ($requests as $req) {
            echo "<tr>
                    <td>{$req['request_id']}</td>
                    <td>{$req['category_name']}</td>
                    <td>{$req['title']}</td>
                    <td>{$req['description']}</td>
                    <td>{$req['location']}</td>
                    <td>{$req['preferred_date']}</td>
                    <td>{$req['status']}</td>
                  </tr>";
        }
        echo "</table>";
    }
}
?>
