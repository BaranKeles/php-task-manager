<?php
// Include the database configuration
global $conn;
include 'db_config.php';

// Fetch tasks from the database
$sql = "SELECT * FROM tasks ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS -->
</head>
<body>
<h1>Task Manager</h1>

<!-- Task Form -->
<form action="add_task.php" method="POST">
    <input type="text" name="title" placeholder="Task Title" required>
    <textarea name="description" placeholder="Task Description"></textarea>
    <button type="submit">Add Task</button>
</form>

<!-- Task List -->
<h2>Your Tasks</h2>
<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($task = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($task['title']); ?></td>
                <td><?php echo htmlspecialchars($task['description']); ?></td>
                <td><?php echo htmlspecialchars($task['status']); ?></td>
                <td>
                    <?php if ($task['status'] !== 'completed'): ?>
                        <a href="edit_task.php?id=<?php echo $task['id']; ?>">Edit</a>
                    <?php endif; ?>
                    <?php if ($task['status'] == 'pending'): ?>
                        <a href="mark_task.php?id=<?php echo $task['id']; ?>">Mark as Completed</a>
                    <?php endif; ?>
                    <a href="delete_task.php?id=<?php echo $task['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No tasks found. Start adding some!</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>