<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["UserID"])) {
    // Redirect to login page if not logged in
    header("Location: ../login.php");
    exit();
}

// Include database connection file
include_once "db.php";

// Handle joining a room
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["join_room"])) {
    $roomID = $_POST["room_id"];
    $userID = $_SESSION["UserID"];

    // Check if the user is already associated with the room
    $checkStmt = $conn->prepare("SELECT * FROM RoomUsers WHERE UserID = ? AND RoomID = ?");
    $checkStmt->bind_param("ii", $userID, $roomID);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // User is already associated with the room, handle duplicate entry (e.g., display an error message)
        $_SESSION["join_error"] = "You are already in this room.";
    } else {
        // Insert user into room
        $insertStmt = $conn->prepare("INSERT INTO RoomUsers (UserID, RoomID) VALUES (?, ?)");
        $insertStmt->bind_param("ii", $userID, $roomID);
        $insertStmt->execute();
    }

    $_SESSION["RoomID"] = $_POST["room_id"];
}

// Handle leaving a room
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["leave_room"])) {
    $roomID = $_POST["room_id"];
    $userID = $_SESSION["UserID"];

    // Remove user from room
    $deleteStmt = $conn->prepare("DELETE FROM RoomUsers WHERE UserID = ? AND RoomID = ?");
    $deleteStmt->bind_param("ii", $userID, $roomID);
    $deleteStmt->execute();
    $_SESSION["RoomID"] = $_SESSION["MyRoomID"];
}

// Redirect back to the previous page after joining or leaving a room
header("Location: ../index.php");
exit();
?>
