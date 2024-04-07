<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["UserID"])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection file
include_once "./backend/db.php";

// Retrieve user's todos from the database
$userID = $_SESSION["UserID"];
$stmt = $conn->prepare("SELECT TodoID, Title, Description, Status FROM Todos WHERE CreatorID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to store todos
$todos = [];
while ($row = $result->fetch_assoc()) {
    $todos[] = $row;
}

// Handle form submissions (e.g., adding or updating todos)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the action is to add a new todo
    if (isset($_POST["add_todo"])) {
        $title = $_POST["title"];
        $description = $_POST["description"];
        // Insert the new todo into the database
        $stmt = $conn->prepare("INSERT INTO Todos (Title, Description, Status, CreatorID) VALUES (?, ?, 'pending', ?)");
        $stmt->bind_param("ssi", $title, $description, $userID);
        $stmt->execute();
        // Redirect back to index page after adding todo
        header("Location: index.php");
        exit();
    }

    // Check if the action is to mark a todo as done
    if (isset($_POST["mark_done"]) && isset($_POST["todo_id"])) {
        $todoID = $_POST["todo_id"];
        // Update the status of the todo to "completed" in the database
        $stmt = $conn->prepare("UPDATE Todos SET Status = 'completed' WHERE TodoID = ?");
        $stmt->bind_param("i", $todoID);
        $stmt->execute();
        // Redirect back to index page after marking todo as done
        header("Location: index.php");
        exit();
    }

    // Check if the action is to delete a todo
    if (isset($_POST["delete"]) && isset($_POST["todo_id"])) {
        $todoID = $_POST["todo_id"];
        // Delete the todo from the database
        $stmt = $conn->prepare("DELETE FROM Todos WHERE TodoID = ?");
        $stmt->bind_param("i", $todoID);
        $stmt->execute();
        // Redirect back to index page after deleting todo
        header("Location: index.php");
        exit();
    }

    // Add more logic for handling other form submissions here
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List - Shared Todos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
</head>
<body>

<section class="section">
    <div class="container">
        <h1 class="title">Todo List</h1>
        
        <!-- Add Todo Form -->
        <div class="box">
            <h2 class="subtitle">Add Todo</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="field">
                    <label class="label">Title</label>
                    <div class="control">
                        <input class="input" type="text" name="title" placeholder="Enter the title">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Description</label>
                    <div class="control">
                        <textarea class="textarea" name="description" placeholder="Enter the description"></textarea>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-primary" type="submit" name="add_todo">Add Todo</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Display Todos -->
        <?php if (!empty($todos)): ?>
        <div class="box">
            <h2 class="subtitle">Todos</h2>
            <?php foreach ($todos as $todo): ?>
            <div class="content">
                <p><strong>Title:</strong> <?php echo $todo["Title"]; ?></p>
                <p><strong>Description:</strong> <?php echo $todo["Description"]; ?></p>
                <p><strong>Status:</strong> <?php echo $todo["Status"]; ?></p>
                <!-- Form for marking todo as done -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display: inline;">
                    <input type="hidden" name="todo_id" value="<?php echo $todo["TodoID"]; ?>">
                    <button class="button is-success is-small" type="submit" name="mark_done">Mark as Done</button>
                </form>
                <!-- Form for deleting todo -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display: inline;">
                    <input type="hidden" name="todo_id" value="<?php echo $todo["TodoID"]; ?>">
                    <button class="button is-danger is-small" type="submit" name="delete">Delete</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="box">
            <p>No todos found.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

</body>
</html>