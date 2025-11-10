<?php
session_start();
require_once __DIR__ . '/../Controller/CSRShortlistSearchController.php';
require_once __DIR__ . '/../Entity/Shortlist.php';

class CSRShortlistSearchBoundary
{
    private CSRShortlistSearchController $controller;
    private int $csrId;

    public function __construct(int $csrId)
    {
        $this->controller = new CSRShortlistSearchController();
        $this->csrId = $csrId;
    }

    // Get filter values from GET
    public function getFilters(): array
    {
        return [
            'location' => $_GET['location'] ?? null,
            'category' => $_GET['category'] ?? null,
            'date'     => $_GET['date'] ?? null
        ];
    }

    // Render results
    public function renderResults(array $items): void
    {
        echo "<ul>";
        foreach ($items as $item) {
            echo "<li>";
            echo "<strong>" . htmlspecialchars($item->title) . "</strong><br>";
            echo "Location: " . htmlspecialchars($item->location) . "<br>";
            echo "Category: " . htmlspecialchars($item->category) . "<br>";
            echo "Date: " . htmlspecialchars($item->date) . "<br>";
            echo "Saved At: " . $item->savedAt->format('Y-m-d H:i') . "<br>";
            echo "</li>";
        }
        echo "</ul>";
    }

    // Render empty message
    public function renderEmpty(): void
    {
        echo "<p>No shortlisted opportunities found matching your filters.</p>";
    }

    // Run the boundary (render HTML + process filters)
    public function run(): void
    {
        $filters = $this->getFilters();
        $results = $this->controller->searchShortlist($this->csrId, $filters);

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
            <a href="">Reset</a>
        </form>

        <hr>

        <h2>My Shortlisted Opportunities</h2>

        <?php
        if (empty($results)) {
            $this->renderEmpty();
        } else {
            $this->renderResults($results);
        }
        ?>

        </body>
        </html>
        <?php
    }
}

// Ensure CSR is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'csr') {
    header("Location: ../../login.php");
    exit;
}

$csrId = $_SESSION['user']['id'];
$boundary = new CSRShortlistSearchBoundary($csrId);
$boundary->run();
?>
