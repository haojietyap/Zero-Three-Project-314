<?php
session_start();
require_once __DIR__ . '/../../Controllers/profiles/GetUserProfilesController.php';
require_once __DIR__ . '/../../Controllers/profiles/SearchUsersProfileController.php';
require_once __DIR__ . '/../../Controllers/profiles/Admin/CheckAdminProfileStatusController.php';
require_once __DIR__ . '/../../Controllers/Profiles/Homeowner/CheckHomeownerProfileStatusController.php';
require_once __DIR__ . '/../../Controllers/Profiles/Cleaner/CheckCleanerProfileStatusController.php';
require_once __DIR__ . '/../../Controllers/profiles/Manager/CheckManagerProfileStatusController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$searchUsersProfileController = new SearchUsersProfileController();
$getUserProfilesController = new GetUserProfilesController();

$checkAdminStatusController = new CheckAdminProfileStatusController();
$checkHomeownerStatusController = new CheckHomeownerProfileStatusController();
$checkCleanerStatusController = new CheckCleanerProfileStatusController();
$checkManagerStatusController = new CheckManagerProfileStatusController();


$keyword = $_GET['search'] ?? '';

$users = $keyword
    ? $searchUsersProfileController->searchUsersProfile($keyword)
    : $getUserProfilesController->getAllUsersProfile();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Profiles</title>
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
            margin: 4px;
        }

        .btn.green { background-color: #22c55e; color: white; }
        .btn.red { background-color: #ef4444; color: white; }
        .btn.blue { background-color: #3b82f6; color: white; }
        .btn.teal { background-color: #14b8a6; color: white; }
        .btn.grey { background-color: #9ca3af; color: white; }

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

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<nav>
    <h1>View All Users Profile</h1>
    <a class="reset-link" href="../logout.php">Logout</a>
</nav>

<div class="container">
    <h2>All Users Profile</h2>
    <form method="GET">
        <input type="text" name="search" placeholder="Search by name or role" value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">Search</button>
		<a href="manage_profiles.php" class="reset-link">Reset</a>
    </form>
    <table>
        <thead>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Role</th>
			<th>Profile Status</th>
			<th>Action</th>
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
<?php
    $userId = $user['id'];
    $role = $user['role'];

	if ($role === 'admin') {
		$status = $checkAdminStatusController->getProfileStatus($userId);
		$base = 'admin';

	}
	elseif ($role === 'manager') {
		$status = $checkManagerStatusController->getProfileStatus($userId);
		$base = 'manager';

	}
	elseif ($role === 'homeowner') {
		$status = $checkHomeownerStatusController->getProfileStatus($userId);
		$base = 'homeowner';

	}
	elseif ($role === 'cleaner') {
		$status = $checkCleanerStatusController->getProfileStatus($userId);
		$base = 'cleaner';
	}

?>

    <tr>
        <td><?= htmlspecialchars($userId) ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($role) ?></td>
        <td><?= $status === 'not_created' ? 'Not Created' : ucfirst($status) ?></td>
        <td>
        
			<?php if (!empty($base)): ?>
				<?php if ($status === 'not_created'): ?>
				<a href="create_<?= $base ?>_profile.php?id=<?= $userId ?>" class="btn green">Create Profile</a>
		
			<?php elseif ($status === 'suspended'): ?>
				<a href="view_<?= $base ?>_profile.php?id=<?= $userId ?>" class="btn grey">View</a>
			<?php else: ?>
			
				<a href="update_<?= $base ?>_profile.php?id=<?= $userId ?>" class="btn blue">Update</a>
				<a href="view_<?= $base ?>_profile.php?id=<?= $userId ?>" class="btn teal">View</a>
				
			<?php if ($status === 'active'): ?>
				<a href="suspend_<?= $base ?>_profile.php?id=<?= $userId ?>" class="btn red" onclick="return confirm('Suspend this profile?')">Suspend</a>
			<?php else: ?>
            
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

        </td>
    </tr>
<?php endforeach; ?>
</tbody>
    
    </table>
	<a href="admin_dashboard.php" class="back-link">Back to Dashboard</a>
</div>
</body>
</html>


