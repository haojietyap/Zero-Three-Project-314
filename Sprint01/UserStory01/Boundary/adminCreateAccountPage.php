<?php

require_once __DIR__ . '/../Controller/createUserAccountController.php';
require_once __DIR__ . '/../Database.php';

$controller = new createUserAccountController();
$message = "";

// fetches profiles for dropdown
$db = new Database();
$conn = $db->getConnection();
$profiles = $conn->query("SELECT profile_id, profile_name FROM user_profiles")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username   = $_POST['username'] ?? '';
    $password   = $_POST['password'] ?? '';
    $email      = $_POST['email'] ?? '';
    $phone      = $_POST['phone'] ?? '';
    $profile_id = (int)($_POST['profile_id'] ?? 0);

    $result = $controller->createUserAccount($username, $password, $email, $phone, $profile_id);

    if ($result) {
        $message = "✅ User account created successfully.";
    } else {
        $message = "❌ Failed to create user account (email may already exist).";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin - Create User Account</title>
</head>

<body>
    <h1>Create User Account</h1>

    <?php if (!empty($message)) : ?>
        <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
    <?php endif; ?>

    <form method="post" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone"><br><br>

        <label>Role / Profile:</label><br>
        <select name="profile_id" required>
            <option value="">-- Select Role --</option>
            <?php foreach ($profiles as $profile): ?>
                <option value="<?php echo $profile['profile_id']; ?>">
                    <?php echo htmlspecialchars($profile['profile_name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Create User Account</button>
    </form>
</body>

</html>