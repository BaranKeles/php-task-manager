<?php
// Include the database configuration
global $conn;
include 'db_config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);

    // Insert the task into the database
    $sql = "INSERT INTO tasks (title, description, status, created_at) VALUES (?, ?, 'pending', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $description);

    if ($stmt->execute()) {
        // Task added successfully, redirect back to index.php
        header("Location: index.php");
        exit();
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }
}