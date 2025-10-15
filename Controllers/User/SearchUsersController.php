<?php
require_once __DIR__ . '/../../Entities/User.php';

class SearchUsersController {
    public function searchUsers($keyword) {
        $user = new User();
        return $user->searchUsers($keyword);
    }
}

