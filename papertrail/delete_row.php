<?php
// delete_row.php

// Include the file containing your database connection details
include 'connection.php';

// Check if 'pno' parameter is set in the URL
if (isset($_GET['pno'])) {
    // Sanitize the pno to prevent SQL injection
    $pno = mysqli_real_escape_string($conn, $_GET['pno']);

    // Start a database transaction for atomicity
    $conn->begin_transaction();

    // Construct the SQL DELETE queries for related tables
    $delete_details_sql = "DELETE FROM details WHERE pno = '$pno'";
    $delete_activity_log_sql = "DELETE FROM activity_log WHERE pno = '$pno'";
    $delete_attachment_sql = "DELETE FROM attachments WHERE pno = '$pno'";
    $delete_future_sql = "DELETE FROM future WHERE pno = '$pno'";

    // Execute the DELETE queries
    if ($conn->query($delete_details_sql) === TRUE &&
        $conn->query($delete_activity_log_sql) === TRUE &&
        $conn->query($delete_attachment_sql) === TRUE &&
        $conn->query($delete_future_sql) === TRUE) {

        // Commit the transaction if all queries executed successfully
        $conn->commit();

        // Redirect back to admin.php after deletion
        header("Location: admin.php");
        exit();
    } else {
        // Rollback the transaction if any query fails
        $conn->rollback();
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // Handle the case where 'pno' parameter is not set
    // Redirect or show an error message
    header("Location: error_page.php");
    exit();
}
?>
