<?php
require_once __DIR__ . '/../../Entities/Favorite.php';

class CheckFavoriteStatusController {
    public function isFavorited($homeownerId, $cleanerId) {
        $favorite = new Favorite();
        return $favorite->isFavorited($homeownerId, $cleanerId);
    }
}

