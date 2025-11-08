<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "zerothree";

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// this will make the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
if ($conn->query($sql) === TRUE) {
} else {
    die("Error creating database: " . $conn->error);
}

$conn->select_db($dbname);

// this will make the users table if it doesn't exist
$tableSQL = "
CREATE TABLE IF NOT EXISTS users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255),
    role ENUM('User Admin','CSR Rep','PIN','Platform Manager') DEFAULT 'PIN',
    status ENUM('Active','Inactive') DEFAULT 'Active'
);";

if (!$conn->query($tableSQL)) {
    die('Error creating table: ' . $conn->error);
}

// this will count the number of entries in the table
$check = $conn->query("SELECT COUNT(*) AS total FROM users");
$count = $check->fetch_assoc()['total'];

// this is if the number counted is 0, it will create 100 sample user data
if ($count == 0) {
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
    $roles = ['User Admin', 'CSR Rep', 'PIN', 'Platform Manager'];
    $statuses = ['Active', 'Inactive'];

    for ($i = 1; $i <= 100; $i++) {
        $name = "user{$i}";
        $email = "email{$i}@example.com";
        $password = "password{$i}";
        $role = $roles[array_rand($roles)];
        $status = $statuses[array_rand($statuses)];
        $stmt->bind_param("sssss", $name, $email, $password, $role, $status);
        $stmt->execute();
    }
}

// this will make the user profile table if it does not exist
$profileTableSQL = "
CREATE TABLE IF NOT EXISTS profiles (
    profileID INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('User Admin','CSR Rep','PIN','Platform Manager') UNIQUE NOT NULL,
    permissions TEXT,
    description TEXT
);";

if (!$conn->query($profileTableSQL)) {
    die('Error creating profiles table: ' . $conn->error);
}

// this will insert the 4 default user profiles into table if it is empty
$checkProfile = $conn->query("SELECT COUNT(*) AS total FROM profiles");
$profileCount = $checkProfile->fetch_assoc()['total'];

if ($profileCount == 0) {
    $stmt = $conn->prepare("INSERT INTO profiles (role, permissions, description) VALUES (?, ?, ?)");

    $profiles = [
        [
            'User Admin',
            'Full access to manage users and profiles',
            'Responsible for managing user accounts and profiles.'
        ],
        [
            'CSR Rep',
            'View and shortlist volunteer opportunities',
            'Acts on behalf of corporate volunteers (CVs) to coordinate with persons-in-need (PINs).'
        ],
        [
            'PIN',
            'Manage personal requests',
            'Person-in-need of receiving assistance from CSR volunteers.'
        ],
        [
            'Platform Manager',
            'Generate reports, manage volunteer services categories',
            'Supervises platform performance and ensures compliance with CSR objectives.'
        ]
    ];

    foreach ($profiles as $p) {
        $stmt->bind_param("sss", $p[0], $p[1], $p[2]);
        $stmt->execute();
    }
}
