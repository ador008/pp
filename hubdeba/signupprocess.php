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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $semester = $_POST["semester"];
    $confirm_password = $_POST["confirm_password"];

    if ($password == $confirm_password) {

        // Insert user data into the database
        $insert_sql = "INSERT INTO user (name, email, password, semester) VALUES ('$full_name', '$email', '$password', '$semester')";

        if ($conn->query($insert_sql) === TRUE) {
            // User registered successfully
            header("Location: signin.php"); // Redirect to home page
            exit();
        } else {
            // Error in database insertion
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    } else {
        // Passwords do not match
        header("Location: signup.php?error=password");
        exit();
    }
}


$conn->close();
?>