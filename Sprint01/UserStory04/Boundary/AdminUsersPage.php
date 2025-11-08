<?php
declare(strict_types=1);

final class AdminUsersPage
{
    private UsersController $controller;

    public function __construct()
    {
        $this->controller = new UsersController();
    }

    public function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            if ($action === 'update') {
                $this->submitUpdate($_POST);
                return;
            }
            if ($action === 'set_status') {
                $this->submitSetStatus($_POST);
                return;
            }
        }
        if (isset($_GET['edit'])) {
            $this->showEdit((int)$_GET['edit'], $_GET['flash'] ?? null, $_GET['error'] ?? null);
            return;
        }
        $this->showList($_GET['flash'] ?? null, $_GET['error'] ?? null);
    }

    private function showList(?string $flash = null, ?string $error = null): void
    {
        $res = $this->controller->listUsers();
        $users = $res['users'] ?? [];
        $err = $error ?: (($res['ok'] ?? false) ? null : ($res['message'] ?? 'Unexpected error'));
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8"/>
            <meta name="viewport" content="width=device-width, initial-scale=1"/>
            <title>UserStory04 — Update + Activate/Suspend</title>
            <style>
                body { font-family: system-ui, Arial, sans-serif; margin: 2rem; }
                .card { max-width: 1280px; padding: 1.25rem; border: 1px solid #ddd; border-radius: 12px; }
                .ok { background:#eefcf1; border:1px solid #bde5c8; padding:.6rem; border-radius:8px; margin:.5rem 0; }
                .err { background:#ffeeee; border:1px solid #f5b5b5; padding:.6rem; border-radius:8px; margin:.5rem 0; }
                table { width: 100%; border-collapse: collapse; margin-top: .75rem; }
                th, td { text-align: left; padding: .55rem .5rem; border-bottom: 1px solid #eee; font-size: .95rem; }
                th { background: #fafafa; }
                .badge { display:inline-block; padding:.2rem .5rem; border-radius:.5rem; background:#f1f5f9; }
                a.btn, button.btn { padding:.3rem .6rem; border:1px solid #ddd; border-radius:.35rem; text-decoration:none; color:#000; background:#fff; cursor:pointer; }
                form.inline { display:inline; margin:0; }
            </style>
        </head>
        <body>
        <div class="card">
            <h2 style="margin:0;">All User Accounts</h2>
            <p style="margin:.25rem 0 0 0;">Edit user details or toggle status.</p>
            <?php if ($flash): ?><div class="ok"><?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
            <?php if ($err): ?><div class="err"><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Password (stored)</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Updated</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): 
                    $status = (string)($u['user_account_status'] ?? '');
                    $next = $status === 'ACTIVE' ? 'SUSPENDED' : 'ACTIVE';
                    $label = $status === 'ACTIVE' ? 'Suspend' : 'Activate';
                ?>
                    <tr>
                        <td><?= (int)$u['userid'] ?></td>
                        <td><?= htmlspecialchars($u['full_name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['email'] ?? '') ?></td>
                        <td><code><?= htmlspecialchars($u['password'] ?? '') ?></code></td>
                        <td><?= htmlspecialchars($u['phone_number'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['address'] ?? '') ?></td>
                        <td><span class="badge"><?= htmlspecialchars($u['user_profiles'] ?? '') ?></span></td>
                        <td><?= htmlspecialchars($status) ?></td>
                        <td><?= htmlspecialchars($u['updated_at'] ?? '') ?></td>
                        <td><a class="btn" href="?edit=<?= (int)$u['userid'] ?>">Edit</a></td>
                        <td>
                            <form class="inline" method="post" action="">
                                <input type="hidden" name="action" value="set_status"/>
                                <input type="hidden" name="userid" value="<?= (int)$u['userid'] ?>"/>
                                <input type="hidden" name="status" value="<?= htmlspecialchars($next, ENT_QUOTES, 'UTF-8') ?>"/>
                                <button class="btn" type="submit"><?= $label ?></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (count($users) === 0): ?>
                    <tr><td colspan="11">No users found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        </body>
        </html>
        <?php
    }

    private function showEdit(int $userid, ?string $flash = null, ?string $error = null, ?array $prefill = null): void
    {
        $res = $this->controller->getUser($userid);
        if (!($res['ok'] ?? false) || empty($res['user'])) {
            header('Location: ./?error=' . urlencode($res['message'] ?? 'User not found'));
            exit;
        }
        $u = $res['user'];
        $v = function($k,$d='') use ($prefill,$u){ return htmlspecialchars((string)($prefill[$k] ?? $u[$k] ?? $d), ENT_QUOTES, 'UTF-8'); };
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8"/>
            <meta name="viewport" content="width=device-width, initial-scale=1"/>
            <title>UserStory04 — Edit User</title>
            <style>
                body { font-family: system-ui, Arial, sans-serif; margin: 2rem; }
                .card { max-width: 720px; padding: 1.25rem; border: 1px solid #ddd; border-radius: 12px; }
                .row { margin-bottom: .75rem; display: grid; grid-template-columns: 180px 1fr; gap: .75rem; align-items:center; }
                input { padding:.6rem; width: 100%; }
                .meta{ color:#555; font-size:.9rem; }
                .ok { background:#eefcf1; border:1px solid #bde5c8; padding:.6rem; border-radius:8px; margin:.5rem 0; }
                .err { background:#ffeeee; border:1px solid #f5b5b5; padding:.6rem; border-radius:8px; margin:.5rem 0; }
                .btn { padding:.6rem 1rem; cursor:pointer; }
                a { text-decoration:none; }
            </style>
        </head>
        <body>
        <div class="card">
            <h2 style="margin:0;">Edit User #<?= (int)$u['userid'] ?></h2>
            <p class="meta">Role: <b><?= htmlspecialchars($u['user_profiles'] ?? '') ?></b> · Status: <b><?= htmlspecialchars($u['user_account_status'] ?? '') ?></b></p>
            <?php if ($flash): ?><div class="ok"><?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
            <?php if ($error): ?><div class="err"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>

            <form method="post" action="">
                <input type="hidden" name="action" value="update"/>
                <input type="hidden" name="userid" value="<?= (int)$u['userid'] ?>"/>

                <div class="row"><label for="full_name">Full Name</label>
                    <input id="full_name" name="full_name" type="text" required value="<?= $v('full_name') ?>"></div>
                <div class="row"><label for="email">Email</label>
                    <input id="email" name="email" type="email" required value="<?= $v('email') ?>"></div>
                <div class="row"><label for="password">Password</label>
                    <input id="password" name="password" type="text" required value="<?= $v('password') ?>">
                </div>
                <div class="row"><label for="phone_number">Phone</label>
                    <input id="phone_number" name="phone_number" type="text" value="<?= $v('phone_number') ?>"></div>
                <div class="row"><label for="address">Address</label>
                    <input id="address" name="address" type="text" value="<?= $v('address') ?>"></div>

                <button class="btn" type="submit">Save Changes</button>
                <a class="btn" href="./">Cancel</a>
            </form>
        </div>
        </body>
        </html>
        <?php
    }

    private function submitUpdate(array $data): void
    {
        $userid = (int)($data['userid'] ?? 0);
        $res = $this->controller->updateUser($userid, $data);
        if ($res['ok'] ?? false) {
            header('Location: ./?flash=' . urlencode($res['message'] ?? 'Updated'));
            exit;
        }
        $this->showEdit($userid, null, $res['message'] ?? 'Update failed', $res['prefill'] ?? $data);
    }

    private function submitSetStatus(array $data): void
    {
        $userid = (int)($data['userid'] ?? 0);
        $status = (string)($data['status'] ?? '');
        $res = $this->controller->setStatus($userid, $status);
        if ($res['ok'] ?? false) {
            header('Location: ./?flash=' . urlencode($res['message'] ?? 'Status updated.'));
            exit;
        }
        $this->showList(null, $res['message'] ?? 'Status update failed');
    }
}
