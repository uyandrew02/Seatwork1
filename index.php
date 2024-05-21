<?php
session_start();

$todoList = isset($_SESSION["todoList"]) ? $_SESSION["todoList"] : array();

function appendData($task, $date, $time) {
    return ['task' => $task, 'date' => $date, 'time' => $time];
}

function deleteData($toDelete, $todoList) {
    foreach ($todoList as $index => $taskData) {
        if ($taskData['task'] === $toDelete) {
            unset($todoList[$index]);
            break;
        }
    }
    return array_values($todoList);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["task"])) {
        echo '<script>alert("Error: Task cannot be empty")</script>';
    } else if (empty($_POST["date"])) {
        echo '<script>alert("Error: Date cannot be empty")</script>';
    } else if (empty($_POST["time"])) {
        echo '<script>alert("Error: Time cannot be empty")</script>';
    } else {
        $newTask = appendData($_POST["task"], $_POST["date"], $_POST["time"]);
        array_push($todoList, $newTask);
        $_SESSION["todoList"] = $todoList;
    }
}

if (isset($_GET['task'])) {
    $todoList = deleteData($_GET['task'], $todoList);
    $_SESSION["todoList"] = $todoList;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
        .task-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .task-text {
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">To-Do List</h1>
        <div class="card">
            <div class="card-header">Add a New Task</div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <input type="text" class="form-control" name="task" placeholder="Enter your task here">
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" name="date">
                    </div>
                    <div class="form-group">
                        <input type="time" class="form-control" name="time">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Tasks</div>
            <ul class="list-group list-group-flush">
                <?php if (empty($todoList)): ?>
                    <li class="list-group-item text-center">No tasks added yet.</li>
                <?php else: ?>
                    <?php foreach ($todoList as $taskData): ?>
                        <li class="list-group-item task-item">
                            <div class="task-text">
                                <strong><?php echo htmlspecialchars($taskData['task']); ?></strong><br>
                                <small>Date: <?php echo htmlspecialchars($taskData['date']); ?></small><br>
                                <small>Time: <?php echo htmlspecialchars($taskData['time']); ?></small>
                            </div>
                            <a href="index.php?task=<?php echo urlencode($taskData['task']); ?>" class="btn btn-danger">Delete</a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
