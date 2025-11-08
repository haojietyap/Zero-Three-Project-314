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
        $this->show();
    }

    public function show(?string $error = null): void
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
            <title>UserStory02 — View All Users (Clean)</title>
            <style>
                body { font-family: system-ui, Arial, sans-serif; margin: 2rem; }
                .card { max-width: 1200px; padding: 1.25rem; border: 1px solid #ddd; border-radius: 12px; }
                table { width: 100%; border-collapse: collapse; margin-top: .75rem; }
                th, td { text-align: left; padding: .55rem .5rem; border-bottom: 1px solid #eee; font-size: .95rem; }
                th { background: #fafafa; }
                .badge { display:inline-block; padding:.2rem .5rem; border-radius:.5rem; background:#f1f5f9; }
                .err { background:#ffeeee; border:1px solid #f5b5b5; padding:.6rem; border-radius:8px; margin:.5rem 0; }
                code { background:#f6f8fa; padding:.1rem .25rem; border-radius:.25rem; }
            </style>
        </head>
        <body>
        <div class="card">
            <h2 style="margin:0;">All User Accounts</h2>
            <?php if ($err): ?><div class="err"><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Password (stored)</th>
                        <th>Phone</</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= (int)$u['userid'] ?></td>
                        <td><?= htmlspecialchars($u['full_name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['email'] ?? '') ?></td>
                        <td><code><?= htmlspecialchars($u['password'] ?? '') ?></code></td>
                        <td><?= htmlspecialchars($u['phone_number'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['address'] ?? '') ?></td>
                        <td><span class="badge"><?= htmlspecialchars($u['user_profiles'] ?? '') ?></span></td>
                        <td><?= htmlspecialchars($u['user_account_status'] ?? '') ?></td>
                        <td><?= htmlspecialchars($u['created_at'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (count($users) === 0): ?>
                    <tr><td colspan="9">No users found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        </body>
        </html>
        <?php
    }
}
