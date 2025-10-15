<?php
require_once __DIR__ . '/../../Entities/Favorite.php';

class GetFavoritesByHomeownerController {
    public function get($homeownerId) {
        $favorite = new Favorite();
        return $favorite->getFavoritesByHomeowner($homeownerId);
    }
}
