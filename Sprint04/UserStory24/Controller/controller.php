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

    public function listShortlist($csrID) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter'])) {
            $filters = $this->boundary->getFilters();
            $shortlist = $this->entity->findByCsr($csrID, $filters);
            $this->boundary->renderList($shortlist);
        } else {
            $shortlist = $this->entity->findByCsr($csrID);
            $this->boundary->renderList($shortlist);
        }
    }
}
?>
