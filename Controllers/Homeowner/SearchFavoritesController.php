<?php
require_once __DIR__ . '/../../Entities/Favorite.php';

class SearchFavoritesController {
    public function search($homeownerId, $keyword) {
        $favorite = new Favorite();
        return $favorite->searchFavoritesByHomeowner($homeownerId, $keyword);
    }
}
