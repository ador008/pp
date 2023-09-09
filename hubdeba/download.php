<?php
if (isset($_GET['file'])) {
    $file = urldecode($_GET['file']);

    // Check if the file exists on the server
    if (file_exists($file)) {
        // Set the appropriate headers to force download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));

        // Output the file for download
        readfile($file);
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}
?>

