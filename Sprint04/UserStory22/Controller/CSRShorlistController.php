<?php
require_once __DIR__ . '/../Entity/Shortlist.php';

class CSRShortlistController {
    public function addToShortlist($csrID, $requestID) {
        $shortlist = new Shortlist($csrID, $requestID);
        $shortlist->save();
    }

    public function listShortlist($csrID) {
        return Shortlist::findByCSR($csrID);
    }
}
?>