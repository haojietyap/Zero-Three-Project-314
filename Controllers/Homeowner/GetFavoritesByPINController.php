<?php
require_once __DIR__ . '/../../Entities/Favorite.php';

class GetFavoritesByPINController {
    public function get($PINId) {
        $favorite = new Favorite();
        return $favorite->getFavoritesByPIN($PINId);
    }
}

