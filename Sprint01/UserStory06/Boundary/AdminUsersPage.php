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
            if ($action === 'assign_role_do') { $this->submitAssignRole(); return; }
        }
        $action = $_GET['action'] ?? '';
        if ($action === 'assign_role') { $this->showAssignRole(); return; }
        if ($action === 'unassigned')  { $this->showUnassigned(); return; }
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
            .toolbar{display:flex;gap:8px;margin:.5rem 0 0 0}
            select{padding:8px;border:1px solid #e5e7eb;border-radius:10px}
        </style></head><body>';
        echo '<h1 style="margin:0 0 12px 0">User Administration</h1>';
    }

    private function htmlFooter(): void { echo '</body></html>'; }

    private function toolbar(): void
    {
        echo '<div class="toolbar">';
        echo '<a class="btn" href="./?action=unassigned">View Unassigned</a>';
        echo '<a class="btn" href="./">All Users</a>';
        echo '</div>';
    }

    private function showList(): void
    {
        $this->htmlHeader('Users — All');
        $this->toolbar();
        $res = $this->controller->listUsers();
        $rows = ($res['ok'] ?? false) ? ($res['users'] ?? []) : [];
        if (!($res['ok'] ?? false)) echo '<p style="color:#b91c1c">'.htmlspecialchars($res['message'] ?? 'Failed').'</p>';
        $this->renderTable($rows, true);
        $this->htmlFooter();
    }

    private function showUnassigned(): void
    {
        $this->htmlHeader('Users — Unassigned');
        $this->toolbar();
        $res = $this->controller->listUnassigned();
        $rows = ($res['ok'] ?? false) ? ($res['users'] ?? []) : [];
        if (!($res['ok'] ?? false)) echo '<p style="color:#b91c1c">'.htmlspecialchars($res['message'] ?? 'Failed').'</p>';
        $this->renderTable($rows, false);
        $this->htmlFooter();
    }

    private function renderTable(array $rows, bool $showEditSuspend): void
    {
        echo '<table>';
        echo '<tr><th>ID</th><th>FULL NAME</th><th>EMAIL</th><th>ROLE</th><th>STATUS</th><th>ACTIONS</th></tr>';
        if (empty($rows)) { echo '<tr><td colspan="6">No users.</td></tr></table>'; return; }

        foreach ($rows as $u) {
            $id     = (int)($u['userid'] ?? 0);
            $name   = htmlspecialchars((string)($u['full_name'] ?? ''), ENT_QUOTES, 'UTF-8');
            $email  = htmlspecialchars((string)($u['email'] ?? ''),      ENT_QUOTES, 'UTF-8');
            $role   = htmlspecialchars((string)($u['role'] ?? ''),       ENT_QUOTES, 'UTF-8');
            $status = htmlspecialchars((string)($u['status'] ?? ''),     ENT_QUOTES, 'UTF-8');

            $assignUrl = './?action=assign_role&userid='.$id;

            echo '<tr>';
            echo '<td>'.$id.'</td>';
            echo '<td>'.$name.'</td>';
            echo '<td>'.$email.'</td>';
            echo '<td>'.($role!==''?$role:'<span class="chip">Unassigned</span>').'</td>';
            echo '<td>'.$status.'</td>';
            echo '<td><a class="btn" href="'.$assignUrl.'">Assign Role</a>';
            if ($showEditSuspend) {
                echo ' <span style="opacity:.6">(Edit/Suspend in main module)</span>';
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    private function showAssignRole(): void
    {
        $userid = isset($_GET['userid']) ? (int)$_GET['userid'] : 0;
        $res = $this->controller->getUser($userid);

        $this->htmlHeader('Assign Role');
        if (!($res['ok'] ?? false)) {
            echo '<p style="color:#b91c1c">'.htmlspecialchars($res['message'] ?? 'User not found').'</p>';
            echo '<p><a class="btn" href="./?action=unassigned">Back</a></p>';
            $this->htmlFooter(); return;
        }
        $u = $res['user'];
        $roles = $this->controller->getAllowedRoles();
        $h = function($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); };

        echo '<h2>Assign Role to '.$h($u['full_name']).' (#'.$h($u['userid']).')</h2>';
        echo '<form method="post" action="./">';
        echo '<input type="hidden" name="action" value="assign_role_do">';
        echo '<input type="hidden" name="userid" value="'.$h($u['userid']).'">';
        echo '<p><label>Role<br><select name="role">';
        foreach ($roles as $r) {
            $sel = ($r === ($u['role'] ?? '')) ? ' selected' : '';
            echo '<option value="'.$h($r).'"'.$sel.'>'.$h($r).'</option>';
        }
        echo '</select></label></p>';
        echo '<p><button class="btn" type="submit">Assign</button> <a class="btn" href="./?action=unassigned">Cancel</a></p>';
        echo '</form>';
        $this->htmlFooter();
    }

    private function submitAssignRole(): void
    {
        $userid = (int)($_POST['userid'] ?? 0);
        $role   = (string)($_POST['role'] ?? '');
        $res = $this->controller->assignRole($userid, $role);
        $msg = $res['ok'] ? $res['message'] : ($res['message'] ?? 'Failed');
        header('Location: ./?action=unassigned&flash='.urlencode($msg)); exit;
    }
}
