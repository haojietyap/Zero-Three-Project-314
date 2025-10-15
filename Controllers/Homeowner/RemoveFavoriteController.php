<?php
require_once __DIR__ . '/../../Entities/Favorite.php';

class RemoveFavoriteController {
    public function remove($homeownerId, $cleanerId) {
        $favorite = new Favorite();
        return $favorite->removeFavorite($homeownerId, $cleanerId);
    }
}
