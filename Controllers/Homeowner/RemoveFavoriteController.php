<?php
require_once __DIR__ . '/../../Entities/Favorite.php';

class RemoveFavoriteController {
    public function remove($PINId, $CSRId) {
        $favorite = new Favorite();
        return $favorite->removeFavorite($PINId, $CSRId);
    }
}

