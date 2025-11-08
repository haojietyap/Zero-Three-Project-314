<?php
require_once __DIR__ . '/../Entity/Shortlist.php';

class CSRShortlistSearchController
{
    private $shortlistEntity;

    public function __construct()
    {
        $this->shortlistEntity = new shortlist();
    }

    public function searchShortlist(int $csrID, array $filters): array
    {
        return $this->shortlistEntity->findByCSRAndFilters($csrID, $filters);
    }
}
?>
