<?php
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

if ($conn) {
    echo "<p style='color:green;'>✅ Database connection successful!</p>";

    $sql = "SELECT COUNT(*) as total FROM users";
    $stmt = $conn->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total users found: " . $row['total'];
} else {
    echo "<p style='color:red;'>❌ Failed to connect to database.</p>";
}
?>
