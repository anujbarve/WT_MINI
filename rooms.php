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

// Retrieve all users and their room IDs from the database
$stmt = $conn->prepare("SELECT UserID, Username, RoomID FROM Users");
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to store users and their room IDs
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <!-- <link rel="stylesheet" href="./assets/vendor/bulma/css/bulma.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
    <script src="./main.js"></script>
</head>

<body>

    <?php include './modules/navbar.php'; ?>

    <section class="section">
        <div class="container">
            <h1 class="title">Registered Users</h1>

            <?php if (!empty($users)) : ?>
                <table class="table is-fullwidth">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Room ID</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?php echo $user["Username"]; ?></td>
                                <td><?php echo $user["RoomID"]; ?></td>
                                <td>
                                    <?php if ($_SESSION["Username"] == $user["Username"]) : ?>
                                        No Operation, This is your room
                                    <?php elseif ($_SESSION["RoomID"] == $user["RoomID"]) : ?>
                                        <form action="./backend/room_management.php" method="post" style="display: inline;">
                                            <input type="hidden" name="room_id" value="<?php echo $user["RoomID"] ?>">
                                            <button class="button is-danger is-small" type="submit" name="leave_room">Leave</button>
                                        </form>
                                    <?php else : ?>
                                        <form action="./backend/room_management.php" method="post" style="display: inline;">
                                            <input type="hidden" name="room_id" value="<?php echo $user["RoomID"] ?>">
                                            <button class="button is-success is-small" type="submit" name="join_room">Join</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No users found.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php include './modules/footer.php'; ?>

</body>

</html>
