<?php
require_once __DIR__ . '/../../Entities/ConfirmedJob.php';

class ViewConfirmedJobsController {
    public function getByCleaner($cleanerId) {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->getJobsByCleaner($cleanerId);
    }

    public function getByHomeowner($homeownerId) {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->getByHomeowner($homeownerId);
    }
}
