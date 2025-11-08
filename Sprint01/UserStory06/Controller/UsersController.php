<?php
declare(strict_types=1);

final class UsersController
{
    private array $allowedRoles = ['PIN','User Admin','CSR Rep','Platform Manager'];

    public function listUsers(): array
    {
        try { return ['ok'=>true,'users'=>User::all()]; }
        catch (\Throwable $e) { return ['ok'=>false,'users'=>[], 'message'=>'Failed to load users: '.$e->getMessage()]; }
    }

    public function listUnassigned(): array
    {
        try { return ['ok'=>true,'users'=>User::unassigned()]; }
        catch (\Throwable $e) { return ['ok'=>false,'users'=>[], 'message'=>'Failed to load unassigned: '.$e->getMessage()]; }
    }

    public function getUser(int $userid): array
    {
        try {
            $row = User::getById($userid);
            return $row ? ['ok'=>true,'user'=>$row] : ['ok'=>false,'message'=>'User not found'];
        } catch (\Throwable $e) {
            return ['ok'=>false,'message'=>'Failed to load user: '.$e->getMessage()];
        }
    }

    public function assignRole(int $userid, string $role): array
    {
        $role = trim($role);
        if (!in_array($role, $this->allowedRoles, true)) {
            return ['ok'=>false,'message'=>'Invalid role'];
        }
        if (!User::existsById($userid)) {
            return ['ok'=>false,'message'=>'User not found'];
        }
        try {
            $ok = User::updateRole($userid, $role);
            return $ok ? ['ok'=>true,'message'=>"Assigned role '$role' to #$userid"] : ['ok'=>false,'message'=>'Assignment failed'];
        } catch (\Throwable $e) {
            return ['ok'=>false,'message'=>'Assignment failed: '.$e->getMessage()];
        }
    }

    public function getAllowedRoles(): array { return $this->allowedRoles; }
}
