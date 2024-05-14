<?php
session_start();

// Initialize to-do list
$todoList = isset($_SESSION["todoList"]) ? $_SESSION["todoList"] : [];

// Function to add a task to the to-do list
function addTask($task, $todoList) {
    if (!in_array($task, $todoList)) {
        $todoList[] = $task;
    }
    return $todoList;
}

// Function to delete a task from the to-do list
function deleteTask($task, $todoList) {
    $index = array_search($task, $todoList);
    if ($index !== false) {
        unset($todoList[$index]);
        $todoList = array_values($todoList); // Re-index array
    }
    return $todoList;
}

// Handling form submission for adding tasks
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["task"])) {
    $task = trim($_POST["task"]);
    if ($task !== "") {
        $todoList = addTask($task, $todoList);
        $_SESSION["todoList"] = $todoList;
    } else {
        echo '<script>alert("Error: Please enter a task.")</script>';
    }
}

// Handling task deletion
if (isset($_GET['delete']) && isset($_GET['task'])) {
    $task = $_GET['task'];
    $todoList = deleteTask($task, $todoList);
    $_SESSION["todoList"] = $todoList;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">To-Do List</h1>
        <div class="card">
            <div class="card-header">Add a new task</div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <input type="text" class="form-control" name="task" placeholder="Enter your task here" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">Tasks</div>
            <ul class="list-group list-group-flush">
                <?php foreach ($todoList as $task): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($task); ?>
                        <a href="?delete=true&task=<?php echo urlencode($task); ?>" class="btn btn-danger btn-sm">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
