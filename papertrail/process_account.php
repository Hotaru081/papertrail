<?php
// Include the file that establishes the database connection
include('connection.php');

// Check if the form is submitted and handle the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the form
    $username = $_POST["username"];
    $password = $_POST["password"]; // Get the password as entered by the user

    // Prepare and bind the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    
    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind parameters to the statement
        $stmt->bind_param("ss", $username, $password);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Close the statement
            $stmt->close();

            // Close the database connection
            $conn->close();

            // Redirect to admin.php with an alert message
            echo "<script>alert('Account added!'); window.location.href = 'admin.php';</script>";
            exit(); // Stop further execution
        } else {
            echo "Error creating account: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error in preparing statement: " . $conn->error;
    }
} else {
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>
