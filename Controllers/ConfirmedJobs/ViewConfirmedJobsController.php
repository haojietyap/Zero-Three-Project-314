<?php
require_once __DIR__ . '/../../Entities/ConfirmedJob.php';

class ViewConfirmedJobsController {
    public function getByCSR($CSRId) {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->getJobsByCSR($CSRId);
    }

    public function getByPIN($PINId) {
        $confirmedJob = new ConfirmedJob();
        return $confirmedJob->getByPIN($PINId);
    }
}

