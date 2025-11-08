<?php
declare(strict_types=1);

final class UsersController
{
    // list (US04)
    public function listUsers(): array
    {
        try {
            return ['ok' => true, 'users' => User::all()];
        } catch (\Throwable $e) {
            return ['ok' => false, 'users' => [], 'message' => 'Failed to load users: '.$e->getMessage()];
        }
    }

    // get one (edit)
    public function getUser(int $userid): array
    {
        try {
            $row = User::getById($userid);
            return $row ? ['ok' => true, 'user' => $row] : ['ok' => false, 'message' => 'User not found'];
        } catch (\Throwable $e) {
            return ['ok' => false, 'message' => 'Failed to load user: '.$e->getMessage()];
        }
    }

    // update
    public function updateUser(array $data): array
    {
        try {
            $id = (int)($data['userid'] ?? 0);
            if (!User::existsById($id)) return ['ok' => false, 'message' => 'User not found'];
            $ok = User::updateUser($data);
            return $ok ? ['ok' => true, 'message' => 'User updated'] : ['ok' => false, 'message' => 'No changes'];
        } catch (\Throwable $e) {
            return ['ok' => false, 'message' => 'Update failed: '.$e->getMessage()];
        }
    }

    // set ACTIVE/SUSPENDED
    public function setStatus(int $userid, string $status): array
    {
        try {
            if (!User::existsById($userid)) return ['ok' => false, 'message' => 'User not found'];
            User::updateStatus($userid, $status);
            return ['ok' => true, 'message' => "User #{$userid} set to ".strtoupper($status)];
        } catch (\Throwable $e) {
            return ['ok' => false, 'message' => 'Failed to update status: '.$e->getMessage()];
        }
    }

    // search (US05)
    public function search(string $q): array
    {
        try {
            $rows = User::search($q);
            return ['ok' => true, 'users' => $rows];
        } catch (\Throwable $e) {
            return ['ok' => false, 'users' => [], 'message' => 'Search failed: '.$e->getMessage()];
        }
    }
}
