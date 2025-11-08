<?php

class User
{
    public int $id;
    public string $name;
    public string $email;
    public string $role;
    public string $status;
    public string $password;

    public function __construct(array $row)
    {
        $this->id       = (int)$row['userID'];
        $this->name     = $row['name'] ?? '';
        $this->email    = $row['email'] ?? '';
        $this->role     = $row['role'] ?? '';
        $this->status   = $row['status'] ?? '';
        $this->password = $row['password'] ?? '';
    }

    public function isInactive(): bool
    {
        return strcasecmp($this->status, 'Inactive') === 0;
    }
}
