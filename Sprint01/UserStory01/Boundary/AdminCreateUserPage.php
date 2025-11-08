<?php
declare(strict_types=1);

final class AdminCreateUserPage
{
    private UsersController $controller;

    public function __construct()
    {
        $this->controller = new UsersController();
    }

    public function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->submit($_POST);
        } else {
            $this->showForm();
        }
    }

    public function showForm(?array $prefill = null, ?string $message = null, ?string $error = null): void
    {
        $v = function($k,$d='') use ($prefill){ return htmlspecialchars((string)($prefill[$k] ?? $d), ENT_QUOTES, 'UTF-8'); };
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8"/>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>UserStory01 — Create User (Clean)</title>
            <style>
                body { font-family: system-ui, Arial, sans-serif; margin: 2rem; }
                .card { max-width: 720px; padding: 1.25rem; border: 1px solid #ddd; border-radius: 12px; }
                .row { margin-bottom: .75rem; display: grid; grid-template-columns: 180px 1fr; gap: .75rem; align-items:center; }
                input { padding:.6rem; width: 100%; }
                .btn { padding:.6rem 1rem; cursor:pointer; }
                .ok { background:#eefcf1; border:1px solid #bde5c8; padding:.75rem; border-radius:8px; margin-bottom:.75rem; }
                .err { background:#ffeeee; border:1px solid #f5b5b5; padding:.75rem; border-radius:8px; margin-bottom:.75rem; }
            </style>
        </head>
        <body>
        <div class="card">
            <h2>Create User Account</h2>
            <?php if ($message): ?><div class="ok"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
            <?php if ($error): ?><div class="err"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>

            <form method="post" action="">
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
                <button class="btn" type="submit">Create User</button>
            </form>
        </div>
        </body>
        </html>
        <?php
    }

    public function submit(array $data): void
    {
        $result = $this->controller->createUser($data);
        if (($result['ok'] ?? false) === true) {
            $this->showForm(null, $result['message'] ?? 'User created.');
        } else {
            $this->showForm($result['prefill'] ?? $data, null, $result['message'] ?? 'Error creating user');
        }
    }
}
