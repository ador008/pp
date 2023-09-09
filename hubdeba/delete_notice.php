<?php
// Start the session
session_start();

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

// Check if the user is logged in and has appropriate privileges
if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] > 0) {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        // Prepare and execute the SQL query to delete the notice
        $deleteSQL = "DELETE FROM notice WHERE id = ?";
        $stmt = $conn->prepare($deleteSQL);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Redirect back to the notice page after deletion
        header("Location: notice.php");
        exit();
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Access denied.";
}

$conn->close();
?>
