<?php
include 'connection.php';

// Check if the 'id' parameter exists in the POST request
if (isset($_POST['id'])) {
    // Sanitize the 'id' to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Perform the delete operation
    $query = "DELETE FROM activity_log WHERE id = $id";
    // Execute the query using your database connection
    if (mysqli_query($conn, $query)) {
        // If deletion is successful, redirect to admin.php
        header("Location: admin.php");
        exit();
    } else {
        echo 'Deletion failed.';
    }
} else {
    echo 'No ID provided for deletion.';
}
?>
