<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection file
    include_once "db.php";

    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate a random room ID for the user
    $roomID = mt_rand(100000, 999999); // Generate a 6-digit random number

    // Prepare SQL statement to insert user into database
    $stmt = $conn->prepare("INSERT INTO Users (Username, Password, RoomID) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $hashed_password, $roomID);

    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful, redirect to login page
        $_SESSION["success"] = "Registration successful. Please login.";
        header("Location: ../login.php");
        exit();
    } else {
        // If registration fails, redirect back to registration page with error message
        $_SESSION["error"] = "Registration failed. Please try again.";
        header("Location: ../register.php");
        exit();
    }
} else {
    // If accessed directly without submitting the form, redirect back to registration page
    header("Location: ../register.php");
    exit();
}
?>
