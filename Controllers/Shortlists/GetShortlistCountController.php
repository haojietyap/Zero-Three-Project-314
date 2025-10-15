<?php
require_once __DIR__ . '/../../Entities/Shortlists.php';

class GetShortlistCountController {
    public function getCount($jobId) {
        $shortlists = new Shortlists();
        return $shortlists->countShortlistsByJobId($jobId);
    }
}
