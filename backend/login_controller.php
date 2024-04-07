<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection file
    include_once "db.php";

    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare SQL statement to fetch user from database
    $stmt = $conn->prepare("SELECT UserID, Username, Password, RoomID FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify username and password
    if ($user && password_verify($password, $user["Password"])) {
        // Set session variables
        $_SESSION["UserID"] = $user["UserID"];
        $_SESSION["Username"] = $user["Username"];
        $_SESSION["RoomID"] = $user["RoomID"];

        // Redirect to main page or dashboard
        header("Location: ../index.php");
        exit();
    } else {
        // If username or password is incorrect, redirect back to login page with error message
        $_SESSION["error"] = "Invalid username or password.";
        header("Location: ../login.php");
        exit();
    }
} else {
    // If accessed directly without submitting the form, redirect back to login page
    header("Location: ../login.php");
    exit();
}
?>