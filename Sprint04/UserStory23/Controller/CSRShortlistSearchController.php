<?php
require_once __DIR__ . '/../Entity/Shortlist.php';

class CSRShortlistSearchController
{
    private Shortlist $entity;

    public function __construct()
    {
        $this->entity = new Shortlist();
    }

    public function searchShortlist(int $csrId, array $filters): array
    {
        return $this->entity->findByCSRandFilters($csrId, $filters);
    }
}
?>
