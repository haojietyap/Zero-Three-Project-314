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
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $action = $_POST['action'] ?? '';
            if ($action === 'update_user') { $this->submitUpdate(); return; }
        }
        $action = $_GET['action'] ?? '';
        if ($action === 'edit') { $this->showEdit(); return; }
        if ($action === 'set_status') { $this->submitSetStatus(); return; }
        $this->showList();
    }

    private function htmlHeader(string $title='User Admin'): void
    {
        echo '<!doctype html><html><head><meta charset="utf-8"><title>'.htmlspecialchars($title).'</title>';
        echo '<style>
            body{font-family:system-ui,Segoe UI,Arial;margin:24px;color:#111}
            table{width:100%;border-collapse:collapse;margin-top:10px}
            th,td{padding:12px 14px;border-bottom:1px solid #e5e7eb;vertical-align:top}
            th{font-weight:700;text-transform:uppercase;font-size:12px;color:#6b7280}
            .chip{display:inline-block;background:#eef2ff;color:#4338ca;padding:6px 10px;border-radius:10px;font-weight:600}
            .btn{display:inline-block;padding:8px 12px;border:1px solid #e5e7eb;border-radius:10px;text-decoration:none;color:#111;background:#fff}
            .btn.danger{border-color:#fecaca}
            code{background:#f8fafc;padding:4px;border-radius:4px}
            .flash.error{color:#b91c1c;margin-top:8px}
        </style></head><body>';
        echo '<h1 style="margin:0 0 12px 0">User Administration</h1>';
    }

    private function htmlFooter(): void { echo '</body></html>'; }

    private function renderSearchForm(string $q=''): void
    {
        $q = htmlspecialchars($q, ENT_QUOTES, 'UTF-8');
        echo '<form method="get" action="./" style="margin:1rem 0 1.25rem 0;">';
        echo '<input type="text" name="q" value="'.$q.'" placeholder="Search name, email, or ID" size="40"> ';
        echo '<button class="btn" type="submit">Search</button> ';
        if ($q !== '') echo '<a class="btn" href="./" style="margin-left:8px">Clear</a>';
        echo '</form>';
    }

    private function showList(): void
    {
        $this->htmlHeader('Users');
        $q = isset($_GET['q']) ? (string)$_GET['q'] : '';
        $this->renderSearchForm($q);

        if ($q !== '') {
            $res = $this->controller->search($q);
            $rows = ($res['ok'] ?? false) ? ($res['users'] ?? []) : [];
            if (!($res['ok'] ?? false)) echo '<div class="flash error">'.htmlspecialchars($res['message'] ?? 'Search failed').'</div>';
            echo '<h2 style="margin:.5rem 0">Results</h2>';
        } else {
            $res = $this->controller->listUsers();
            $rows = ($res['ok'] ?? false) ? ($res['users'] ?? []) : [];
            if (!($res['ok'] ?? false)) echo '<div class="flash error">'.htmlspecialchars($res['message'] ?? 'Failed to load users').'</div>';
            echo '<h2 style="margin:.5rem 0">All Users</h2>';
        }

        $this->renderTable($rows);
        $this->htmlFooter();
    }

    private function renderTable(array $rows): void
    {
        echo '<table>';
        echo '<tr><th>ID</th><th>FULL NAME</th><th>EMAIL</th><th>PASSWORD</th><th>PHONE</th><th>ADDRESS</th><th>ROLE</th><th>STATUS</th><th>UPDATED</th><th>ACTIONS</th></tr>';
        if (empty($rows)) { echo '<tr><td colspan="10">No users found.</td></tr></table>'; return; }

        foreach ($rows as $u) {
            $id     = (int)($u['userid'] ?? 0);
            $name   = htmlspecialchars((string)($u['full_name'] ?? ''), ENT_QUOTES, 'UTF-8');
            $email  = htmlspecialchars((string)($u['email'] ?? ''),      ENT_QUOTES, 'UTF-8');
            $pwd    = htmlspecialchars((string)($u['password'] ?? ''),   ENT_QUOTES, 'UTF-8');
            $phone  = htmlspecialchars((string)($u['phone_number'] ?? ''), ENT_QUOTES, 'UTF-8');
            $addr   = htmlspecialchars((string)($u['address'] ?? ''),    ENT_QUOTES, 'UTF-8');
            $role   = htmlspecialchars((string)($u['role'] ?? ''),       ENT_QUOTES, 'UTF-8');
            $status = htmlspecialchars(strtoupper((string)($u['status'] ?? '')), ENT_QUOTES, 'UTF-8');
            $updated= htmlspecialchars((string)($u['updated'] ?? ''),    ENT_QUOTES, 'UTF-8');

            $toggleNext = (strtoupper((string)($u['status'] ?? '')) === 'ACTIVE') ? 'SUSPENDED' : 'ACTIVE';
            $toggleLabel = ($toggleNext === 'ACTIVE') ? 'Activate' : 'Suspend';

            echo '<tr>';
            echo '<td>'.$id.'</td>';
            echo '<td>'.$name.'</td>';
            echo '<td>'.$email.'</td>';
            echo '<td><code>'.$pwd.'</code></td>';
            echo '<td>'.$phone.'</td>';
            echo '<td>'.$addr.'</td>';
            echo '<td><span class="chip">'.$role.'</span></td>';
            echo '<td>'.$status.'</td>';
            echo '<td>'.$updated.'</td>';
            echo '<td><a class="btn" href="./?action=edit&userid='.$id.'">Edit</a> ';
            echo '<a class="btn danger" href="./?action=set_status&userid='.$id.'&status='.$toggleNext.'">'.$toggleLabel.'</a></td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    private function showEdit(): void
    {
        $id = isset($_GET['userid']) ? (int)$_GET['userid'] : 0;
        $res = $this->controller->getUser($id);

        $this->htmlHeader('Edit User');
        if (!($res['ok'] ?? false)) {
            echo '<div class="flash error">'.htmlspecialchars($res['message'] ?? 'User not found').'</div>';
            echo '<p><a class="btn" href="./">Back</a></p>';
            $this->htmlFooter(); return;
        }

        $u = $res['user'];
        $h = function($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); };

        echo '<form method="post" action="./">';
        echo '<input type="hidden" name="action" value="update_user">';
        echo '<input type="hidden" name="userid" value="'.$h($u['userid']).'">';
        echo '<p><label>Full name<br><input type="text" name="full_name" value="'.$h($u['full_name']).'" required></label></p>';
        echo '<p><label>Email<br><input type="email" name="email" value="'.$h($u['email']).'" required></label></p>';
        echo '<p><label>Password (leave blank to keep)<br><input type="text" name="password" value=""></label></p>';
        echo '<p><label>Phone<br><input type="text" name="phone_number" value="'.$h($u['phone_number']).'"></label></p>';
        echo '<p><label>Address<br><input type="text" name="address" value="'.$h($u['address']).'"></label></p>';
        echo '<p><button class="btn" type="submit">Save</button> <a class="btn" href="./">Cancel</a></p>';
        echo '</form>';
        $this->htmlFooter();
    }

    private function submitUpdate(): void
    {
        $data = [
            'userid'       => $_POST['userid'] ?? '',
            'full_name'    => $_POST['full_name'] ?? '',
            'email'        => $_POST['email'] ?? '',
            'password'     => $_POST['password'] ?? '',
            'phone_number' => $_POST['phone_number'] ?? '',
            'address'      => $_POST['address'] ?? '',
        ];
        $res = $this->controller->updateUser($data);
        $msg = $res['ok'] ? 'User updated' : ($res['message'] ?? 'Update failed');
        header('Location: ./?flash='.urlencode($msg)); exit;
    }

    private function submitSetStatus(): void
    {
        $id = isset($_GET['userid']) ? (int)$_GET['userid'] : 0;
        $status = isset($_GET['status']) ? (string)$_GET['status'] : 'SUSPENDED';
        $res = $this->controller->setStatus($id, $status);
        $msg = $res['ok'] ? ($res['message'] ?? 'Updated') : ($res['message'] ?? 'Failed');
        header('Location: ./?flash='.urlencode($msg)); exit;
    }
}
