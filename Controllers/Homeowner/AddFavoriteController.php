<?php
require_once __DIR__ . '/../../Entities/Favorite.php';

class AddFavoriteController {
    public function add($PINId, $CSRId) {
        $favorite = new Favorite();
        return $favorite->addFavorite($PINId, $CSRId);
    }
}

