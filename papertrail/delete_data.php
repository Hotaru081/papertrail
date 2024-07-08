<?php
include('connection.php');

// Check if the 'pno' and 'timestamp' POST parameters are set
if (isset($_POST['pno']) && isset($_POST['timestamp'])) {
    $pno = $_POST['pno'];
    $timestamp = $_POST['timestamp'];

    // Perform the deletion in your database based on 'pno' and 'timestamp'
    $delete_query = mysqli_query($conn, "DELETE FROM attachments WHERE pno = '$pno' AND timestamp = '$timestamp'");

    if ($delete_query) {
        // Deletion successful
        echo "success";
    } else {
        // Deletion failed
        echo "error";
    }
} else {
    // Invalid request
    echo "error";
}
?>
