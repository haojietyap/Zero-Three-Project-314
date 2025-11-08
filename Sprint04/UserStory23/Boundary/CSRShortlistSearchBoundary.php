<?php
session_start();
require_once __DIR__ . '/../controller/CSRShortlistSearchController.php';

class csrShortlistSearchBoundary
{
    private $controller;
    private int $csrId;

    public function __construct(int $csrId)
    {
        $this->controller = new csrShortlistSearchController();
        $this->csrId = $csrId;
    }

    // Get filter values from form submission
    public function getFilters(): array
    {
        return [
            'location' => $_GET['location'] ?? null,
            'category' => $_GET['category'] ?? null,
            'date'     => $_GET['date'] ?? null
        ];
    }

    // Fetch results from controller
    public function getResults(array $filters): array
    {
        return $this->controller->searchShortlist($this->csrId, $filters);
    }
}

// Ensure the CSR is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'csr') {
    header("Location: ../../login.php");
    exit;
}

$csrId = $_SESSION['user']['id']; // use logged-in CSR ID

// Instantiate boundary
$boundary = new csrShortlistSearchBoundary($csrId);
$filters = $boundary->getFilters();
$results = $boundary->getResults($filters);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSR Shortlist Search</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        form { margin-bottom: 20px; }
        input, button { margin: 5px; padding: 6px; }
        label { margin-right: 5px; }
        ul { list-style: none; padding: 0; }
        li { margin-bottom: 15px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
    </style>
</head>
<body>

<h1>Search My Shortlisted Opportunities</h1>

<form method="GET" action="">
    <label>Location:</label>
    <input type="text" name="location" value="<?= htmlspecialchars($filters['location'] ?? '') ?>" placeholder="e.g. Miami">

    <label>Category:</label>
    <input type="text" name="category" value="<?= htmlspecialchars($filters['category'] ?? '') ?>" placeholder="e.g. Community">

    <label>Date:</label>
    <input type="date" name="date" value="<?= htmlspecialchars($filters['date'] ?? '') ?>">

    <button type="submit">Search</button>
    <a href="csrShortlistSearchBoundary.php">Reset</a>
</form>

<hr>

<h2>My Shortlisted Opportunities</h2>

<?php if (empty($results)): ?>
    <p>No shortlisted opportunities found matching your filters.</p>
<?php else: ?>
    <ul>
        <?php foreach ($results as $item): ?>
            <li>
                <strong><?= htmlspecialchars($item['title']) ?></strong><br>
                Location: <?= htmlspecialchars($item['location']) ?><br>
                Category: <?= htmlspecialchars($item['category']) ?><br>
                Date: <?= htmlspecialchars($item['date']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>
