<?php
require_once __DIR__ . '/../../Entities/User.php';

class CreateUserController {
    public function createUser($username, $email, $password, $role) {
        $user = new User();
        return $user->createUser($username, $email, $password, $role);
    }
}
