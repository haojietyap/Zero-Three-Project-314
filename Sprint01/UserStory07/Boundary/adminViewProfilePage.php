<?php

require_once __DIR__ . '/../Controller/viewProfileController.php';

$controller = new viewProfileController();
$profiles = $controller->viewUserProfiles();
?>
<!DOCTYPE html>
<html>

<head>
    <title>View User Profiles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 10px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>User Profiles</h2>

        <?php if (empty($profiles)): ?>
            <p>No profiles found.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Profile ID</th>
                    <th>Profile Name</th>
                    <th>Description</th>
                </tr>
                <?php foreach ($profiles as $p): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($p['profile_id']); ?></td>
                        <td><?php echo htmlspecialchars($p['profile_name']); ?></td>
                        <td><?php echo htmlspecialchars($p['description']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>