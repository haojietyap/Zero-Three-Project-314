<?php
require_once __DIR__ . '/../Controller/viewUserAccountController.php';

$controller = new viewUserAccountController();
$userAccounts = $controller->viewUserAccountData();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin - View User Accounts</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
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
    <h1>View User Accounts</h1>
    <?php if (empty($userAccounts)): ?>
        <p><strong>No user accounts found or an error occurred.</strong></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role / Profile</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userAccounts as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                        <td><?php echo htmlspecialchars($user['profile_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>