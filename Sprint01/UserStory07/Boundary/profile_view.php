<?php

if (!isset($view)) {
    header('Location: ../Controller/ViewProfilesController.php');
    exit;
}

$error = $_GET['error'] ?? '';
$msg   = $_GET['msg']   ?? '';
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>User Profiles</title>
</head>

<body>

    <?php if ($msg): ?><p style="color:green;"><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
    <?php if ($error): ?><p style="color:red;"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>

    <?php if ($view === 'list'): ?>
        <?php if (!isset($profiles)) {
            header('Location: ../Controller/ViewProfilesController.php');
            exit;
        } ?>
        <h1>User Profiles</h1>

        <?php if (empty($profiles)): ?>
            <p>No profiles found.</p>
        <?php else: ?>
            <table border="1" cellpadding="6" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Role</th>
                        <th>Permissions</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($profiles as $p): ?>
                        <tr>
                            <td><?php echo (int)$p->id; ?></td>
                            <td><?php echo htmlspecialchars($p->role); ?></td>
                            <td><?php echo htmlspecialchars($p->permissions); ?></td>
                            <td><?php echo htmlspecialchars($p->description); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    <?php else: ?>
        <p>Unknown view.</p>
    <?php endif; ?>

</body>

</html>