<?php
// Simple seeder script to initialize mock data or database tables
echo "Seeding application...\n";

$requests = [
    ['userID' => 1, 'title' => 'System Bug', 'description' => 'Login issue detected', 'priority' => 'High'],
    ['userID' => 2, 'title' => 'UI Enhancement', 'description' => 'Add dark mode', 'priority' => 'Medium']
];

$file = __DIR__ . '/requests.json';
file_put_contents($file, json_encode($requests, JSON_PRETTY_PRINT));

echo "Seeded successfully. Data saved to requests.json\n";
?>
