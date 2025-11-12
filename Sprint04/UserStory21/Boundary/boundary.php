<?php
class ViewPINRequestsBoundary {

    // Render the search/filter form and request list
    public function renderList($requests = []) {
        echo "<h2>Requests Created by PIN Users</h2>";

        if (empty($requests)) {
            $this->renderEmpty();
            return;
        }

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>
                <th>Request ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Category</th>
                <th>Location</th>
                <th>Preferred Date</th>
                <th>Status</th>
              </tr>";

        foreach ($requests as $req) {
            echo "<tr>
                    <td>{$req['request_id']}</td>
                    <td>{$req['title']}</td>
                    <td>{$req['description']}</td>
                    <td>{$req['category_name']}</td>
                    <td>{$req['location']}</td>
                    <td>{$req['preferred_date']}</td>
                    <td>{$req['status']}</td>
                  </tr>";
        }

        echo "</table>";
    }

    // Show "No Requests" message
    public function renderEmpty() {
        echo "<p style='color:red;'>No Requests Available.</p>";
    }

    // Optional filter fields (not mandatory, but included for CSR filtering)
    public function getFilters() {
        return [
            'keyword' => trim($_POST['keyword'] ?? ''),
            'status'  => $_POST['status'] ?? ''
        ];
    }
}
?>
