<?php
require_once __DIR__ . '/../../Entities/ConfirmedJob.php';

class FilterConfirmedJobsByPINController {
    public function filter($PINId, $categoryId, $startDate, $endDate) {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->filterByPINServiceAndDate($PINId, $categoryId, $startDate, $endDate);
    }
}

