<?php

if (!isset($user) || !isset($roles)) {
    header('Location: ../Controller/ViewUsersController.php');
    exit;
}
$error = $_GET['error'] ?? '';
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Edit User #<?php echo htmlspecialchars((string)$user->id); ?></title>
</head>

<body>
    <h1>Edit User #<?php echo htmlspecialchars((string)$user->id); ?></h1>

    <?php if ($error): ?>
        <div style="color:red;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="../Controller/EditUserController.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars((string)$user->id); ?>">

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

        <label>Password <br>(leave blank to keep current password)<br>
            <input type="text" name="password" value="">
        </label><br><br>

        <label>Status<br>
            <input type="text" value="<?php echo htmlspecialchars($user->status); ?>" disabled>
        </label><br><br>

        <button type="submit">Save Changes</button>
    </form>

    <p><a href="../Controller/ViewUsersController.php">Back to users</a></p>
</body>

</html>