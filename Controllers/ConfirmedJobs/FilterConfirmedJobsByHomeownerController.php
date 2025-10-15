<?php
require_once __DIR__ . '/../../Entities/ConfirmedJob.php';

class FilterConfirmedJobsByHomeownerController {
    public function filter($homeownerId, $categoryId, $startDate, $endDate) {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->filterByHomeownerServiceAndDate($homeownerId, $categoryId, $startDate, $endDate);
    }
}
