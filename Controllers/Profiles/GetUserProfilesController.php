<?php
require_once __DIR__ . '/../../Entities/User.php';

class GetUserProfilesController {
    public function getAllUsersProfile(){
        $user = new User();
        return $user->getAllUsersProfile();
    }
}
