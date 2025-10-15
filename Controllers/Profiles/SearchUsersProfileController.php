<?php
require_once __DIR__ . '/../../Entities/User.php';

class SearchUsersProfileController {
    public function searchUsersProfile($keyword) {
        $user = new User();
        return $user->searchUsersProfile($keyword);
    }
}
