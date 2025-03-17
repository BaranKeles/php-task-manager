<?php
// Include the database configuration
global $conn;
include 'db_config.php';

// Check if the 'id' parameter is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Sanitize the task ID to ensure it's a valid number
    $task_id = intval($_GET['id']);

    // Prepare the SQL DELETE statement
    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        // Task deleted successfully, redirect back to index.php
        header("Location: index.php");
        exit;
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }
} else {
    // If no valid task ID is provided, redirect back to index.php
    header("Location: index.php");
    exit;
}