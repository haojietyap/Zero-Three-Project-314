<?php

if (!isset($view)) { header('Location: ../Controller/ViewProfilesController.php'); exit; }

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
  <?php if (!isset($profiles)) { header('Location: ../Controller/ViewProfilesController.php'); exit; } ?>
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
          <th>Edit</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($profiles as $p): ?>
        <tr>
          <td><?php echo (int)$p->id; ?></td>
          <td><?php echo htmlspecialchars($p->role); ?></td>
          <td><?php echo htmlspecialchars($p->permissions); ?></td>
          <td><?php echo htmlspecialchars($p->description); ?></td>
          <td>
            <a href="../Controller/EditProfileController.php?id=<?php echo (int)$p->id; ?>">Edit</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

<?php elseif ($view === 'edit'): ?>
  <?php if (!isset($profile, $roles)) { header('Location: ../Controller/ViewProfilesController.php'); exit; } ?>
  <h1>Edit Profile #<?php echo (int)$profile->id; ?></h1>

  <form method="post" action="../Controller/EditProfileController.php">
    <input type="hidden" name="id" value="<?php echo (int)$profile->id; ?>">

    <label>Role<br>
      <select name="role" required>
        <?php foreach ($roles as $r): ?>
          <option value="<?php echo htmlspecialchars($r); ?>" <?php echo ($r === $profile->role ? 'selected' : ''); ?>>
            <?php echo htmlspecialchars($r); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label><br><br>

    <label>Permissions<br>
      <textarea name="permissions" rows="4" cols="60" required><?php echo htmlspecialchars($profile->permissions); ?></textarea>
    </label><br><br>

    <label>Description<br>
      <textarea name="description" rows="3" cols="60" required><?php echo htmlspecialchars($profile->description); ?></textarea>
    </label><br><br>

    <button type="submit">Save Changes</button>
  </form>

  <p style="margin-top:12px;">
    <a href="../Controller/ViewProfilesController.php">Back to Profiles</a>
  </p>

<?php else: ?>
  <p>Unknown view.</p>
<?php endif; ?>

</body>
</html>
