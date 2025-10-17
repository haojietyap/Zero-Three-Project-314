<?php
require_once __DIR__ . '/../../Entities/Favorite.php';

class CheckFavoriteStatusController {
    public function isFavorited($PINId, $CSRId) {
        $favorite = new Favorite();
        return $favorite->isFavorited($PINId, $CSRId);
    }
}


