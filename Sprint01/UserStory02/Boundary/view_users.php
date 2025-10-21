<?php

// this bounces if $users data is not shown to the controller
if (!isset($users)) {
    header('Location: ../Controller/ViewUsersController.php');
    exit;
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>User List</title>
</head>

<body>
    <h1>User List</h1>

    <?php if (empty($users)): ?>
        <p>No users found.</p>
    <?php else: ?>
        <table border="1" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <th>UserID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars((string)$u->id); ?></td>
                        <td><?php echo htmlspecialchars($u->name); ?></td>
                        <td><?php echo htmlspecialchars($u->email); ?></td>
                        <td><?php echo htmlspecialchars($u->role); ?></td>
                        <td><?php echo htmlspecialchars($u->status); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>