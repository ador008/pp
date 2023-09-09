<?php
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

if (isset($_POST['subject'])) {
    $subject = $_POST['subject'];
    
    // Fetch subjects based on the selected subject
    $sql = "SELECT chapter_number,chapter FROM chaptername WHERE subject = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $subject);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Build the options for the subject dropdown
    $options = '';
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['chapter_number']}'>{$row['chapter_number']} - {$row['chapter']}</option>";
    }
    
    echo $options;
    
    $stmt->close();
}

$conn->close();
?>
