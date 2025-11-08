<?php
declare(strict_types=1);

final class UsersController
{
    public function listUsers(): array
    {
        try {
            $rows = User::all();
            return ['ok' => true, 'users' => $rows];
        } catch (\Throwable $e) {
            return ['ok' => false, 'users' => [], 'message' => 'Server error: ' . $e->getMessage()];
        }
    }
}
