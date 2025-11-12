<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';

class CSRShortlistController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new CSRShortlistBoundary();
        $this->entity = new Shortlist();
    }

    public function addToShortlist($csrID, $requestID) {
        $this->boundary->clickSave($requestID);
        $result = $this->entity->addToShortlist($csrID, $requestID);

        if ($result['success']) {
            $this->boundary->renderFeedback($result['message'], true);
        } else {
            $this->boundary->renderFeedback($result['message'], false);
        }

        // Display updated shortlist
        $shortlist = $this->entity->findByCsr($csrID);
        $this->boundary->renderShortlist($shortlist);
    }
}
?>
