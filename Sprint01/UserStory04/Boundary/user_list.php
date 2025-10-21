<?php

if (!isset($view)) {
    header('Location: ../Controller/ViewUsersController.php');
    exit;
}

$error = $_GET['error'] ?? '';
$msg   = $_GET['msg']   ?? '';
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>User List</title>
</head>

<body>

    <?php if ($msg): ?>
        <p style="color:green;"><?php echo htmlspecialchars($msg); ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($view === 'list'): ?>
        <?php if (!isset($users)) {
            header('Location: ../Controller/ViewUsersController.php');
            exit;
        } ?>
        <h1>User List</h1>

        <?php if (empty($users)): ?>
            <p>No users found.</p>
        <?php else: ?>
            <table border="1" cellpadding="6" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Activate/Suspend</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?php echo (int)$u->id; ?></td>
                            <td><?php echo htmlspecialchars($u->name); ?></td>
                            <td><?php echo htmlspecialchars($u->email); ?></td>
                            <td><?php echo htmlspecialchars($u->role); ?></td>
                            <td><?php echo htmlspecialchars($u->status); ?></td>
                            <td>
                                <a href="../Controller/EditUserController.php?id=<?php echo (int)$u->id; ?>">Edit</a>
                            </td>
                            <td>
                                <?php if ($u->status === 'Active'): ?>
                                    <form method="post" action="../Controller/ToggleStatusController.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo (int)$u->id; ?>">
                                        <input type="hidden" name="action" value="suspend">
                                        <button type="submit">Suspend</button>
                                    </form>
                                <?php else: ?>
                                    <form method="post" action="../Controller/ToggleStatusController.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo (int)$u->id; ?>">
                                        <input type="hidden" name="action" value="activate">
                                        <button type="submit">Activate</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    <?php elseif ($view === 'edit'): ?>
        <?php if (!isset($user, $roles)) {
            header('Location: ../Controller/ViewUsersController.php');
            exit;
        } ?>
        <h1>Edit User #<?php echo (int)$user->id; ?></h1>

        <form method="post" action="../Controller/EditUserController.php">
            <input type="hidden" name="id" value="<?php echo (int)$user->id; ?>">

            <label>Name<br>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user->name); ?>" required>
            </label><br><br>

            <label>Email<br>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" required>
            </label><br><br>

            <label>Role<br>
                <select name="role" required>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?php echo htmlspecialchars($r); ?>" <?php echo ($r === $user->role ? 'selected' : ''); ?>>
                            <?php echo htmlspecialchars($r); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label><br><br>

            <label>Password (leave blank to keep current)<br>
                <input type="text" name="password" value="">
            </label><br><br>

            <label>Status (read-only)<br>
                <input type="text" value="<?php echo htmlspecialchars($user->status); ?>" disabled>
            </label><br><br>

            <button type="submit">Save Changes</button>
        </form>

        <p><a href="../Controller/ViewUsersController.php">Back to Users</a></p>

    <?php else: ?>
        <p>Unknown view.</p>
    <?php endif; ?>

</body>

</html>