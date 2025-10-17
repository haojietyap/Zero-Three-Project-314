<?php
require_once __DIR__ . '/../../Entities/Favorite.php';

class SearchFavoritesController {
    public function search($PINId, $keyword) {
        $favorite = new Favorite();
        return $favorite->searchFavoritesByPIN($PINId, $keyword);
    }
}

