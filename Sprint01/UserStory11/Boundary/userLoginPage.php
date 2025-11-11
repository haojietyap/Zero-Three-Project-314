<?php


session_start();
require_once __DIR__ . '/../Controller/LoginController.php';

$controller = new LoginController();
$errorMessage = '';
$loggedIn = isset($_SESSION['admin_email']);

// handles logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: userLoginPage.php');
    exit;
}

// handles login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email      = $_POST['email']      ?? '';
    $password   = $_POST['password']   ?? '';
    $profile_id = isset($_POST['profile_id']) ? (int)$_POST['profile_id'] : 0;

    $isValid = $controller->validateAccount($email, $password, $profile_id); // bool

    if ($isValid) {
        $_SESSION['admin_email'] = $email;
        $_SESSION['profile_id']  = $profile_id;
        $loggedIn = true;
    } else {
        $errorMessage = 'Invalid email, password, or role. Please try again.';
        $loggedIn = false;
    }
}

function getRoleName($profile_id)
{
    switch ($profile_id) {
        case 1:
            return 'User Admin';
        case 2:
            return 'PIN';
        case 3:
            return 'CSR';
        case 4:
            return 'Platform Manager';
        default:
            return 'Unknown Role';
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>User Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 420px;
            margin: 60px auto;
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
        }

        button {
            margin-top: 15px;
            padding: 8px 16px;
            width: 100%;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .home {
            text-align: center;
        }

        a.logout {
            display: inline-block;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if (!$loggedIn): ?>
            <h2>User Admin Login</h2>
            <form method="post" action="">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>

                <label for="profile_id">Login As</label>
                <select name="profile_id" id="profile_id" required>
                    <option value="">-- Select Role --</option>
                    <option value="1">User Admin</option>
                    <option value="2">PIN</option>
                    <option value="3">CSR</option>
                    <option value="4">Platform Manager</option>
                </select>

                <button type="submit">Log In</button>
            </form>

            <?php if ($errorMessage !== ''): ?>
                <div class="error"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>
        <?php else: ?>

            <div class="home">
                <h2>Admin Home</h2>
                <p>You are logged in as <strong><?php echo htmlspecialchars($_SESSION['admin_email']); ?></strong></p>
                <p>Role: <strong><?php echo htmlspecialchars(getRoleName($_SESSION['profile_id'])); ?></strong></p>
                <p>From here, you can manage user accounts and profiles.</p>
                <a class="logout" href="?logout=1">Log Out</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>