<?php

if (!isset($users)) {
    header('Location: ../Controller/ViewUsersController.php');
    exit;
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>User Accounts</title>
</head>

<body>
    <h1>User Accounts</h1>

    <?php if (isset($_GET['msg'])): ?>
        <p style="color:green;"><?php echo htmlspecialchars($_GET['msg']); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

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
                    <th>Edit</th>
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
                        <td>
                            <a href="../Controller/EditUserController.php?id=<?php echo htmlspecialchars((string)$u->id); ?>">
                                Edit
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>