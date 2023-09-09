<?php
// Start the session
session_start();

// Check if the user is not logged in, redirect to signin page
if (!isset($_SESSION["user_id"])) {
    header("Location: signin.php");
    exit();
}

// Replace these variables with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "hub";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get notice ID from the form data
$noticeId = $_POST["notice_id"];

// Get updated notice details from the form data
$updatedTitle = $_POST["title"];
$updatedFile = $_POST["file"];

// Update notice details in the database
$updateSQL = "UPDATE notice SET title = '$updatedTitle', download = '$updatedFile' WHERE id = '$noticeId'";

if ($conn->query($updateSQL) === TRUE) {
    // Redirect back to the specified return URL after successful update
    $return_url = isset($_POST['return_url']) ? $_POST['return_url'] : 'notice.php';
    header("Location: " . $return_url . "?success=1"); // Adding "?success=1" to the URL
    exit();
} else {
    // Handle error
}

$conn->close();
?>
