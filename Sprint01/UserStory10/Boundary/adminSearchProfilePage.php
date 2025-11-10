<?php

require_once __DIR__ . '/../Controller/searchProfileController.php';

$controller = new searchProfileController();
$results = [];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_name = $_POST['profile_name'] ?? '';
    $results = $controller->searchUserProfile($profile_name);

    if (empty($results)) {
        $message = "❌ No profile found with that name.";
    } else {
        $message = "✅ " . count($results) . " profile(s) found.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Search User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
        }

        input {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
        }

        button {
            padding: 8px 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Search User Profile</h2>

        <form method="post" action="">
            <label>Profile Name</label><br>
            <input type="text" name="profile_name" placeholder="Enter profile name" required><br>
            <button type="submit">Search</button>
        </form>

        <?php if ($message !== "") : ?>
            <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
        <?php endif; ?>

        <?php if (!empty($results)) : ?>
            <table>
                <tr>
                    <th>Profile ID</th>
                    <th>Profile Name</th>
                    <th>Description</th>
                </tr>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['profile_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['profile_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>