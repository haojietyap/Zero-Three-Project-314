<?php
require_once __DIR__ . '/../../Entities/User.php';

class UpdateUserController {
    public function updateUser($userId, $name, $email, $role) {
        $user = new User();
        return $user->updateUser($userId, $name, $email, $role);
    }
}
