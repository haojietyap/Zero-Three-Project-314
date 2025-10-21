<?php
$error = $_GET['error'] ?? '';
$msg   = $_GET['msg'] ?? '';
if (!isset($roles)) {
    header('Location: ../Controller/CreateProfileController.php');
    exit;
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Create User Profile</title>
</head>

<body>
    <h1>Create User Profile</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($msg): ?>
        <p style="color:green;"><?php echo htmlspecialchars($msg); ?></p>
    <?php endif; ?>

    <form method="post" action="../Controller/CreateProfileController.php" autocomplete="off">
        <label>Role<br>
            <select name="role" required>
                <option value="" disabled selected>-- Select Role --</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?php echo htmlspecialchars($r); ?>"><?php echo htmlspecialchars($r); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <br><br>

        <label>Permissions<br>
            <textarea name="permissions" rows="4" cols="60" placeholder="Describe the permissions for this role" required></textarea>
        </label>
        <br><br>

        <label>Description<br>
            <textarea name="description" rows="3" cols="60" placeholder="High-level description of the role" required></textarea>
        </label>
        <br><br>

        <button type="submit">Create Profile</button>
    </form>

    <p style="margin-top:12px;">

        <a href="../../UserStory05/Controller/ViewUsersController.php">Back to User Admin Dashboard</a>
    </p>
</body>

</html>