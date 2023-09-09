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

    $subject = $_GET['subject'];
    if (isset($_GET['came_from'])) {
        $came_from = $_GET['came_from'];
    } else {
        $came_from = "suggestion";
    }



    if (isset($_GET["question"])) {
        $ques = urldecode($_GET["question"]);
    
        $tables = ["subject", "subject1", "subject2", "subject3"];
    
        foreach ($tables as $table) {
            $deleteSQL = "DELETE FROM $table WHERE question_name = ?";
            $stmt = $conn->prepare($deleteSQL);
            $stmt->bind_param("s", $ques);
            
            if ($stmt->execute()) {
                if($stmt->num_rows < 1 ){
                    continue;
                }
                // Deletion was successful, exit the loop
                break;
            }
        }
        
        $stmt->close();

        // Redirect back to the notice page after deletion
         header("Location: subject.php?subject=" . urlencode($subject) . "&chapter=" . urlencode($_GET['chapter']) . "&came_from=" . urlencode($came_from) . "&success=2");

        exit();
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Access denied.";
}

$conn->close();
