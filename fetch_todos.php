<?php
session_start();

// Include database connection file
include_once "./backend/db.php";

// Retrieve user's room ID from session
$roomID = $_SESSION["RoomID"];

// Retrieve user's todos from the database based on the room ID
$stmt = $conn->prepare("SELECT TodoID, Title, Description, Status FROM Todos WHERE RoomID = ?");
$stmt->bind_param("i", $roomID);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to store todos
$todos = [];
while ($row = $result->fetch_assoc()) {
    $todos[] = $row;
}

// Check if there are any todos
if (!empty($todos)) {
    // Output HTML for todo list
    foreach ($todos as $todo) {
    ?>
        <div class="content">
        <p><strong>Title:</strong><?php echo $todo["Title"] ?></p>
        <p><strong>Description:</strong><?php echo $todo["Description"] ?></p>
        <p><strong>Status:</strong><?php echo $todo["Status"] ?></p>
        <form action="" method="post" style="display: inline;">
        <input type="hidden" name="todo_id" value="<?php echo $todo["TodoID"] ?>">
        <button class="button is-primary is-small" type="submit" name="mark_done">Mark as Done</button>
        </form>
        <form action="" method="post" style="display: inline;">
        <input type="hidden" name="todo_id" value="<?php echo $todo["TodoID"] ?>">
        <button class="button is-danger is-small" type="submit" name="delete">Delete</button>
        </form>
        </div>
    <?php
    }
} else {
    // Output message if no todos found
    echo '<div class="box">';
    echo '<p>No todos found.</p>';
    echo '</div>';
}
?>