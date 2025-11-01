<?php
require_once __DIR__ . '/../Entities/User.php';

class LoginController {
    public function loginUser($email, $password) {
        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if ($user && $password === $user['password']) {
            return $user;
        }

        return false;
    }
}
