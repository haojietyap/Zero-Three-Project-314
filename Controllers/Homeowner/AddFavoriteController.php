<?php
require_once __DIR__ . '/../../Entities/Favorite.php';

class AddFavoriteController {
    public function add($homeownerId, $cleanerId) {
        $favorite = new Favorite();
        return $favorite->addFavorite($homeownerId, $cleanerId);
    }
}
