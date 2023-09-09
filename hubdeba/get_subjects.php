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

if (isset($_POST['semester'])) {
    $semester = $_POST['semester'];
    
    // Fetch subjects based on the selected semester
    $sql = "SELECT subject FROM semester WHERE semester_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $semester);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Build the options for the subject dropdown
    $options = '';
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='{$row['subject']}'>{$row['subject']}</option>";
    }
    
    echo $options;
    
    $stmt->close();
}

$conn->close();
?>
