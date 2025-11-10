<?php

require_once __DIR__ . '/../Controller/searchAccountController.php';

$controller = new searchAccountController();
$result = null;
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $result = $controller->searchUserAccount($email);

    if ($result === null) {
        $message = "No user found with that email.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Search User Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
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
        <h2>Search User Account</h2>

        <form method="post" action="">
            <label>Email</label><br>
            <input type="email" name="email" placeholder="Enter existing user email" required><br>
            <button type="submit">Search</button>
        </form>

        <?php if (!empty($message)) : ?>
            <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
        <?php endif; ?>

        <?php if ($result !== null): ?>
            <h3>User Details</h3>
            <table>
                <tr>
                    <th>User ID</th>
                    <td><?php echo htmlspecialchars($result['user_id']); ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?php echo htmlspecialchars($result['username']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($result['email']); ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?php echo htmlspecialchars($result['phone']); ?></td>
                </tr>
                <tr>
                    <th>Profile ID</th>
                    <td><?php echo htmlspecialchars($result['profile_id']); ?></td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td><?php echo htmlspecialchars($result['profile_name']); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo htmlspecialchars($result['status']); ?></td>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>