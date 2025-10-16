<?php
session_start();
require_once __DIR__ . '/../../Controllers/ConfirmedJobs/AddConfirmedJobController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'PIN') {
    header("Location: ../../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobId = $_POST['job_id'] ?? null;
    $CSRId = $_POST['CSR_id'] ?? null;
    $PINId = $_SESSION['user']['id'];
    $matchedDate = date('Y-m-d');

    if ($jobId && $CSRId) {
        $controller = new AddConfirmedJobController();
        $success = $controller->add($jobId, $CSRId, $PINId, $matchedDate);

        if ($success) {
            header("Location: view_confirmed_jobs_PIN.php?status=success");
            exit;
        } else {
            $error = "Failed to confirm the job.";
        }
    } else {
        $error = "Missing job or CSR ID.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm Job</title>
</head>
<body>
    <h2>Confirm Consultation Job</h2>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <!-- Optional display or redirect message -->
    <a href="javascript:history.back()">Go Back</a>
</body>
</html>

