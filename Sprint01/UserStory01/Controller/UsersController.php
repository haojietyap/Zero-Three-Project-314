<?php
declare(strict_types=1);

final class UsersController
{
    public function createUser(array $data): array
    {
        $err = $this->validate($data);
        if ($err !== null) return ['ok'=>false, 'message'=>$err, 'prefill'=>$data];

        try {
            if (User::emailExists($data['email'])) {
                return ['ok'=>false, 'message'=>'Email is already in use.', 'prefill'=>$data];
            }

            $newId = User::createAccount([
                'full_name'    => trim((string)$data['full_name']),
                'email'        => trim((string)$data['email']),
                'password'     => (string)$data['password'],
                'phone_number' => trim((string)($data['phone_number'] ?? '')),
                'address'      => trim((string)($data['address'] ?? '')),
            ]);

            return ['ok'=>true, 'message'=>"User #{$newId} created."];
        } catch (\Throwable $e) {
            return ['ok'=>false, 'message'=>'Server error: '.$e->getMessage(), 'prefill'=>$data];
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
