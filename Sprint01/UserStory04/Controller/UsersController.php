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

    public function getUser(int $userid): array
    {
        try {
            $row = User::findById($userid);
            if (!$row) return ['ok'=>false, 'message'=>'User not found'];
            return ['ok'=>true, 'user'=>$row];
        } catch (\Throwable $e) {
            return ['ok'=>false, 'message'=>'Server error: '.$e->getMessage()];
        }
    }

    public function updateUser(int $userid, array $data): array
    {
        if ($userid <= 0) return ['ok'=>false, 'message'=>'Invalid user id.', 'prefill'=>$data];
        $err = $this->validate($data);
        if ($err !== null) return ['ok'=>false, 'message'=>$err, 'prefill'=>$data];

        try {
            if (!User::existsById($userid)) return ['ok'=>false, 'message'=>'User not found', 'prefill'=>$data];
            if (!User::emailUniqueForUpdate($userid, $data['email'])) {
                return ['ok'=>false, 'message'=>'Email is already in use by another user.', 'prefill'=>$data];
            }

            User::updateBasic($userid, [
                'full_name'    => trim((string)$data['full_name']),
                'email'        => trim((string)$data['email']),
                'password'     => (string)$data['password'],
                'phone_number' => trim((string)($data['phone_number'] ?? '')),
                'address'      => trim((string)($data['address'] ?? '')),
            ]);

            return ['ok'=>true, 'message'=>"User #{$userid} updated."];
        } catch (\Throwable $e) {
            return ['ok'=>false, 'message'=>'Server error: '.$e->getMessage(), 'prefill'=>$data];
        }
    }

    public function setStatus(int $userid, string $status): array
    {
        $status = strtoupper(trim($status));
        if ($userid <= 0) return ['ok'=>false, 'message'=>'Invalid user id.'];
        if (!in_array($status, ['ACTIVE','SUSPENDED'], true)) {
            return ['ok'=>false, 'message'=>'Invalid status.'];
        }
        try {
            if (!User::existsById($userid)) return ['ok'=>false, 'message'=>'User not found.'];
            User::updateStatus($userid, $status);
            return ['ok'=>true, 'message'=>"User #{$userid} status set to {$status}."];
        } catch (\Throwable $e) {
            return ['ok'=>false, 'message'=>'Server error: '.$e->getMessage()];
        }
    }

    private function validate(array $d): ?string
    {
        $name = trim((string)($d['full_name'] ?? ''));
        $email = trim((string)($d['email'] ?? ''));
        $password = (string)($d['password'] ?? '');

        if ($name === '') return 'Full name is required.';
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) return 'Invalid email.';
        if ($password === '') return 'Password is required.';
        return null;
    }
}
