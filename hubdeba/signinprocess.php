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
    $email = $_POST["email"];
    $password = $_POST["pw"];

    // Check if the provided email and password match a user in the database
    $sql = "SELECT id, password, name ,type FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row["password"]; // Retrieve the stored password from the database
        
        // Verify the password
        if ($password == $stored_password) {
            // Start the session and store user data
            session_start();
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"];
            $_SESSION["user_type"] = $row["type"];
            
           
            // Redirect to home.php
            header("Location: home.php");
        } else {
            // Password doesn't match, redirect back to signin.php with error
            header("Location: signin.php?error=invalid");
        }
    } else {
        // No user found with the provided email, redirect back to signin.php with error
        header("Location: signin.php?error=invalid");
    }
}

$conn->close();
?>
