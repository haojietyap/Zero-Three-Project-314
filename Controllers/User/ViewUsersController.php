<?php
require_once __DIR__ . '/../../Entities/User.php';

class ViewUsersController {
    public function getAllUsers() {
        $user = new User();
        return $user->getAllUsers();
    }
}
