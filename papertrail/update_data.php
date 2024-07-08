<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $pno = $_POST['pno'];
    $timestamp = $_POST['timestamp'];
    $particulars = $_POST['particulars'];
    $papertype = $_POST['papertype'];

    // Process file uploads if new files are provided
    if (!empty($_FILES['new_files']['name'][0])) {
        $upload_path = 'Uploads/';

        // Delete existing files associated with the timestamp
        mysqli_query($conn, "DELETE FROM attachments WHERE pno = '$pno' AND timestamp = '$timestamp'");

        // Iterate through each uploaded file
        foreach ($_FILES['new_files']['name'] as $key => $file_name) {
            $file_tmp = $_FILES['new_files']['tmp_name'][$key];

            // Move the uploaded file to the desired location
            move_uploaded_file($file_tmp, $upload_path . $file_name);

            // Insert a new record for each uploaded file
            mysqli_query($conn, "INSERT INTO attachments (pno, timestamp, image, particulars, papertype) VALUES ('$pno', NOW(), '$file_name', '$particulars', '$papertype')");
        }
    }

    // Perform other necessary database update operations based on $pno, $timestamp, $particulars, and $papertype

    // Redirect back to the attachments page after updating
    header("Location: attachment.php?pno=$pno");
    exit();
} else {
    // If the form is not submitted via POST, redirect to an error page or the attachments page
    header("Location: error.php"); // You can replace 'error.php' with the appropriate error page
    exit();
}
?>
