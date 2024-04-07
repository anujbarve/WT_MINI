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

// Initialize variables
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve room ID from the form
    $roomID = $_POST["room_id"];

    // Check if the room ID exists in the database
    $stmt = $conn->prepare("SELECT RoomID FROM Todos WHERE RoomID = ?");
    $stmt->bind_param("i", $roomID);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Room ID exists, assign it to the user
        $_SESSION["RoomID"] = $roomID;
        // Redirect to index page
        header("Location: index.php");
        exit();
    } else {
        // Room ID does not exist, display error message
        $error = "Invalid room ID. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Shared Todo - Shared Todos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
</head>
<body>

<section class="section">
    <div class="container">
        <h1 class="title">Join Shared Todo</h1>
        
        <!-- Display error message if any -->
        <?php if (!empty($error)): ?>
        <div class="notification is-danger">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>

        <!-- Join Todo Form -->
        <div class="box">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="field">
                    <label class="label">Room ID</label>
                    <div class="control">
                        <input class="input" type="text" name="room_id" placeholder="Enter Room ID">
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-primary" type="submit">Join Todo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

</body>
</html>