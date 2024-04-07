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

// Retrieve user's room ID from session
$roomID = $_SESSION["RoomID"];

// Retrieve user's todos from the database based on the room ID
$stmt = $conn->prepare("SELECT TodoID, Title, Description, Status FROM Todos WHERE RoomID = ?");
$stmt->bind_param("i", $roomID);
$stmt->execute();
$result = $stmt->get_result();

// Retrieve users accessing the shared todo list
$stmt_users = $conn->prepare("SELECT DISTINCT u.Username FROM Users u JOIN Todos t ON u.RoomID = t.RoomID WHERE t.RoomID = ?");
$stmt_users->bind_param("i", $roomID);
$stmt_users->execute();
$result_users = $stmt_users->get_result();

// Initialize an array to store todos
$todos = [];
while ($row = $result->fetch_assoc()) {
    $todos[] = $row;
}

// Initialize an array to store users accessing the shared todo list
$users = [];
while ($row_user = $result_users->fetch_assoc()) {
    $users[] = $row_user["Username"];
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

<?php

include './modules/navbar.php';

?>

<section class="section">
    <div class="container">
        <h1 class="title">Todo List</h1>

        <!-- Display Room ID -->
        <p>Room ID: <?php echo $roomID; ?></p>
        
        <!-- Display Users Accessing the Shared Todo List -->
        <p>Users accessing this shared todo list: <?php echo implode(", ", $users); ?></p>
        
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
                <form action="./backend/dashboard_controller.php" method="post" style="display: inline;">
                    <input type="hidden" name="todo_id" value="<?php echo $todo["TodoID"]; ?>">
                    <button class="button is-success is-small" type="submit" name="mark_done">Mark as Done</button>
                </form>
                <!-- Form for deleting todo -->
                <form action="./backend/dashboard_controller.php" method="post" style="display: inline;">
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

<?php

include './modules/footer.php';

?>

</body>
</html>