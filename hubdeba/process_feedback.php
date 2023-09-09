<?php
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["Name"];
    $contact = $_POST["Contact_Number"];
    $email = $_POST["Email"];
    $message = $_POST["Message"];

    // Insert the form data into the feedback table
    $insertSQL = "INSERT INTO feedback (name, contact, email, message) VALUES ('$name', '$contact', '$email', '$message')";

    if ($conn->query($insertSQL) === TRUE) {
        // Data inserted successfully
        echo "Feedback submitted successfully!";
    } else {
        // Handle error
        echo "Error: " . $insertSQL . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
