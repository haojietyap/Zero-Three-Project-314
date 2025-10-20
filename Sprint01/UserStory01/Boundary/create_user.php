<?php

$error = $_GET['error'] ?? '';
$msg   = $_GET['msg'] ?? '';
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Create User Account</title>
</head>

<body>
    <h1>Create New User Account</h1>

    <?php if ($error): ?>
        <div style="color:red;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($msg): ?>
        <div style="color:green;"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>

    <form method="post" action="../Controller/CreateUserController.php" autocomplete="off">
        <label>Name<br>
            <input type="text" name="name" required>
        </label><br><br>

        <label>Email<br>
            <input type="email" name="email" required>
        </label><br><br>

        <label>Password<br>
            <input type="text" name="password" required>
        </label><br><br>

        <label>Role<br>
            <select name="role">
                <option value="User Admin">User Admin</option>
                <option value="CSR Rep">CSR Rep</option>
                <option value="PIN">PIN</option>
                <option value="Platform Manager">Platform Manager</option>
            </select>
        </label><br><br>

        <button type="submit">Create User</button>
    </form>
</body>

</html>