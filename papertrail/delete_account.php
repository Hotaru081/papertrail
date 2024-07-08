<?php
// Include the database connection file
include 'connection.php';

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    // Escape the ID to prevent SQL injection
    $id = $conn->real_escape_string($_GET['id']);

    // SQL query to delete the record from the database
    $sql = "DELETE FROM users WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            echo "Record deleted successfully";
            // Redirect to add_account.php after deletion
            header('Location: add_account.php');
            exit(); // Ensure script stops after redirection
        } else {
            echo "No records deleted. ID might not exist.";
        }
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No ID provided for deletion";
}

// Close the database connection
$conn->close();
?>
