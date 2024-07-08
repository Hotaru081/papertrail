<?php
include('connection.php');

$id = $_GET['id'];

if (isset($_POST['submit'])) {
    // Data is being submitted via the "submit" button.
    $pno = $_POST['pno'];
    $particulars = $_POST['particulars'];
    $papertype = $_POST['papertype'];
    $amount = $_POST['amount'];
    $Edate = $_POST['Edate'];
    $status = $_POST['status'];
    $office = $_POST['office'];
    $comments = $_POST['comments'];
    $Eno = $_POST['Eno'];
    $PRno = $_POST['PRno'];
    $PRdate = $_POST['PRdate'];
    $POno = $_POST['POno'];
    $POdate = $_POST['POdate'];
    $person = $_POST['person'];
    $admin = $_POST['admin'];

    // Handle multiple file uploads for 'attachments' table
    $filenames = array();

    if (!empty($_FILES['files']['name'][0])) {
        $targetDir = "Uploads/";

        // Loop through each file
        foreach ($_FILES['files']['name'] as $key => $value) {
            $filename = basename($_FILES['files']['name'][$key]);
            $targetFile = $targetDir . $filename;
            $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

            // Check if the file type is allowed
            if (in_array($fileType, array("pdf", "jpg", "jpeg", "png"))) {
                // Check if the file exists, validate size, and file type here as needed
                if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $targetFile)) {
                    echo "The file " . htmlspecialchars($filename) . " has been uploaded.";
                    $filenames[] = $filename;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    // Handle the error here, or you can choose to continue without the file
                }
            } else {
                echo "Invalid file type. Only PDF, JPG, JPEG, and PNG files are allowed.";
                // Handle the error here, or you can choose to continue without the file
            }
        }
    }

    // Fetch existing data from the database
    $fetch_query = "SELECT * FROM `details` WHERE id='$id'";
    $result = mysqli_query($conn, $fetch_query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        $data_changed = false; // Flag to track if data has changed

        // Compare existing data with new data
        if ($row['pno'] != $pno || $row['particulars'] != $particulars || $row['papertype'] != $papertype || $row['amount'] != $amount || $row['Edate'] != $Edate || $row['office'] != $office ||
            $row['comments'] != $comments || $row['Eno'] != $Eno || $row['PRno'] != $PRno || $row['PRdate'] != $PRdate || $row['POno'] != $POno || $row['POdate'] != $POdate || $row['person'] != $person || $row['admin'] != $admin) {
            // Data is different
            $data_changed = true;

            // Proceed with update
            $update_query = "UPDATE `details` SET pno='$pno', particulars='$particulars', papertype='$papertype', amount='$amount', Edate='$Edate', status='$status', office='$office', comments='$comments', Eno='$Eno', PRno='$PRno', PRdate='$PRdate', POno='$POno', POdate='$POdate', person='$person', admin='$admin', timestamp=NOW() WHERE id='$id'";
            if (mysqli_query($conn, $update_query)) {

                // Your existing code for file uploads remains unchanged here

            } else {
                echo "Error updating details: " . mysqli_error($conn);
            }
        }
    }
    // Check if files are uploaded and data is unchanged
    if ((!$data_changed && !empty($filenames)) || (!$data_changed && empty($filenames))) {
        foreach ($filenames as $filename) {
            $attachments_query = "INSERT INTO attachments (pno, particulars, papertype, image, timestamp)
                                VALUES ('$pno', '$particulars', '$papertype', '$filename', NOW())";

            if (mysqli_query($conn, $attachments_query)) {
                echo "File details inserted successfully.";
            } else {
                echo "Error inserting data into attachments: " . mysqli_error($conn);
            }
        }
    }

    // Insert into activity_log only if data has changed or files are uploaded
    if ($data_changed || (!empty($filenames) && !$data_changed)) {
        $activity_description = (!empty($filenames)) ? "File Uploaded" : "Updated";
        // Insert into activity_log
        $activity_query = "INSERT INTO activity_log (pno, particulars, papertype, amount, Edate, status, office, comments, Eno, PRno, PRdate, POno, POdate, person, admin, timestamp, activity_description) 
        VALUES ('$pno', '$particulars', '$papertype', '$amount', '$Edate', '$status', '$office', '$comments', '$Eno', '$PRno', '$PRdate', '$POno', '$POdate', '$person', '$admin', NOW(), '$activity_description')";

        if (mysqli_query($conn, $activity_query)) {
            // Redirect if successful
            header("Location: search.php");
            exit();
        } else {
            echo "Error inserting activity log: " . mysqli_error($conn);
        }
    } else {
        // Redirect if no changes and no files uploaded
        header("Location: search.php");
        exit();
    }
} else {
    // If the "submit" button is not pressed, redirect to search.php
    header("Location: search.php");
    exit();
}
?>
