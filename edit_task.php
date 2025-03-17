<?php
// Include the database configuration
global $conn;
include 'db_config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Retrieve and sanitize form data
    $task_id = intval($_POST['id']); // Sanitize task ID
    $title = htmlspecialchars($_POST['title']); // Sanitize title
    $description = htmlspecialchars($_POST['description']); // Sanitize description

    // Prepare the SQL UPDATE statement
    $sql = "UPDATE tasks SET title = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $description, $task_id); // 'ssi' means string, string, integer

    if ($stmt->execute()) {
        // Task updated successfully, redirect back to index.php
        header("Location: index.php");
        exit;
    } else {
        // Handle error
        echo "Error: " . $stmt->error;
    }
}

// Fetch the task data
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = intval($_GET['id']);
    $sql = "SELECT * FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional CSS link -->
</head>
<body>
    <h1>Edit Task</h1>

    <!-- Edit Task Form -->
    <form action="edit_task.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($task['id']); ?>">
        <label for="title">Task Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
        <label for="description">Task Description:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($task['description']); ?></textarea>
<button type="submit">Update Task</button>
</form>
</body>
</html>