<?php
session_start();
require_once __DIR__ . '/../../Controllers/User/ViewUsersController.php';
require_once __DIR__ . '/../../Controllers/User/SearchUsersController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$SearchUserController = new SearchUsersController();
$ViewUserController = new ViewUsersController();

$keyword = $_GET['search'] ?? '';
$users = $keyword
    ? $SearchUserController->searchUsers($keyword)
    : $ViewUserController->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
            color: #2c3e50;
            min-height: 100vh;
        }

        nav {
            background-color: #111827;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        nav h1 {
            font-size: 24px;
        }

        .reset-link {
            background-color: #f87171;
            color: white;
            padding: 10px 16px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .reset-link:hover {
            background-color: #ef4444;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            background-color: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        h2 {
            font-size: 32px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 32px;
            color: #3b82f6;
        }

        form {
            display: flex;
            gap: 12px;
            margin-bottom: 30px;
        }

        input[type="text"] {
            flex: 1;
            padding: 14px 18px;
            border-radius: 14px;
            border: 1px solid #d1d5db;
            font-size: 16px;
            background-color: #f9fafb;
        }

        button {
            background-color: #3b82f6;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2563eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-radius: 12px;
            overflow: hidden;
        }

        th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: 600;
        }

        th, td {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .btn {
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-green {
            background-color: #22c55e;
            color: white;
        }

        .btn-yellow {
            background-color: #facc15;
            color: #111827;
        }

        .btn-red {
            background-color: #ef4444;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .back-link {
            display: block;
            margin-top: 30px;
            text-align: center;
            color: #3b82f6;
            font-weight: 600;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            form {
                flex-direction: column;
            }

            .action-buttons {
                flex-direction: row;
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>

<nav>
    <h1>👥 User Management</h1>
    <a class="reset-link" href="../logout.php">Logout</a>
</nav>

<div class="container">
    <h2>All Users</h2>
    <form method="GET">
        <input type="text" name="search" placeholder="Search name, email, or role..." value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">🔍 Search</button>
        <a href="view_users.php" class="reset-link">Reset</a>
    </form>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>👤 Name</th>
            <th>📧 Email</th>
            <th>🏷️ Role</th>
            <th>📍 Status</th>
            <th>⚙️ Action</th>
        </tr>
        </thead>
        <tbody>
		<?php if ($keyword && empty($users)): ?>
		<tr>
        <td colspan="5" style="text-align: center; color: red; font-weight: bold;">
            Name does not exist.
        </td>
		</tr>
		<?php endif; ?>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td>
                    <span style="font-weight: 600; color: <?= $user['status'] === 'suspended' ? '#ef4444' : '#10b981' ?>;">
                        <?= ucfirst($user['status']) ?>
                    </span>
                </td>
                <td>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <a href="update_user.php?id=<?= $user['id'] ?>" class="btn btn-green">✏️ Update</a>

                        <?php if ($user['status'] === 'suspended'): ?>
                            <span class="btn btn-yellow">🚫 Suspended</span>
                        <?php else: ?>
                            <a href="suspend_user.php?id=<?= $user['id'] ?>" class="btn btn-red" onclick="return confirm('Suspend this account?')">
                                🔒 Suspend
                            </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
