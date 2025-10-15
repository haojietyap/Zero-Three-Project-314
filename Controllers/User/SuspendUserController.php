<?php
require_once __DIR__ . '/../../Entities/User.php';

class SuspendUserController {
    public function suspend($userId) {
        $user = new User();
        return $user->suspendUser($userId);
    }
}
