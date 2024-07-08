<?php
// Include your database connection code here
include('connection.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $particulars = $_POST['particulars'];
    $papertype = $_POST['papertype'];
    $amount = $_POST['amount'];
    $taon = $_POST['taon']; 
    $resp_center = $_POST['resp_center']; 
    $account_type = $_POST['account_type']; 
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

    // Check if files have been uploaded
    if (isset($_FILES['image']['name'])) {
        $fileCount = count($_FILES['image']['name']);
        $filenames = array(); // To store uploaded filenames

        for ($i = 0; $i < $fileCount; $i++) {
            $targetDir = "Uploads/";
            $filename = basename($_FILES["image"]["name"][$i]);
            $targetFile = $targetDir . $filename;
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if the file type is allowed
            if (in_array($fileType, array("pdf", "jpg", "jpeg", "png"))) {
                // Check if the file exists, validate size, and file type here as you did before
                if (move_uploaded_file($_FILES["image"]["tmp_name"][$i], $targetFile)) {
                    echo "The file " . htmlspecialchars($filename) . " has been uploaded.";
                    $filenames[] = $filename; // Store the uploaded filename
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    // Handle the error here, or you can choose to continue without the file
                }
            } else {
                echo "Invalid file type. Only PDF, JPG, JPEG, and PNG files are allowed.";
                // Handle the error here, or you can choose to continue without the file
            }
        }

        // Insert data into the "details" table (excluding the image column)
        $sql = "INSERT INTO details (particulars, papertype, amount, taon, resp_center, account_type, Edate, status, office, comments, Eno, PRno, PRdate, POno, POdate, person, admin)
        VALUES ('$particulars', '$papertype', '$amount', '$taon', '$resp_center', '$account_type', '$Edate', '$status', '$office', '$comments', '$Eno', '$PRno', '$PRdate', '$POno', '$POdate', '$person', '$admin')";

        if ($conn->query($sql) === TRUE) {
            // Get the ID of the inserted record
            $pno = $conn->insert_id;

            // Insert an entry into the "activity_log" table
            $activity_description = "Recorded";
            $activity_query = "INSERT INTO activity_log (pno, particulars, papertype, amount, Edate, status, office, comments, Eno, PRno, PRdate, POno, POdate, person, admin, timestamp, activity_description)
            VALUES (NOW(), '$particulars', '$papertype', '$amount', '$Edate', '$status', '$office', '$comments', '$Eno', '$PRno', '$PRdate', '$POno', '$POdate', '$person', '$admin', NOW(), '$activity_description')";

            if ($conn->query($activity_query) === TRUE) {
                // Insert data into "attachments" table if files were uploaded
                if (!empty($filenames)) {
                    foreach ($filenames as $filename) {
                        $attachment_query = "INSERT INTO attachments (pno, particulars, papertype, image, timestamp)
                        VALUES (NOW(), '$particulars', '$papertype', '$filename', NOW())";

                        if ($conn->query($attachment_query) !== TRUE) {
                            echo "Error inserting into attachments table: " . $conn->error;
                            // Handle the error here
                        }
                    }
                }

                // Insert data into "future" table if files were uploaded
                $future_query = "INSERT INTO future (pno, particulars, amount, taon, resp_center, account_type)
                VALUES (NOW(), '$particulars', '$amount', '$taon', '$resp_center', '$account_type')";

                if ($conn->query($future_query) !== TRUE) {
                    echo "Error inserting into future table: " . $conn->error;
                    // Handle the error here
                }

                header("Location: admin.php");
                exit();
            } else {
                echo "Error inserting activity log: " . $conn->error;
            }
        } else {
            echo "Error inserting into details: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // If no files were uploaded, insert into the "details" table and activity log
        $sql = "INSERT INTO details (particulars, papertype, amount, taon, resp_center, account_type, Edate, status, office, comments, Eno, PRno, PRdate, POno, POdate, person, admin)
        VALUES ('$particulars', '$papertype', '$amount', '$taon', '$resp_center', '$account_type', '$Edate', '$status', '$office', '$comments', '$Eno', '$PRno', '$PRdate', '$POno', '$POdate', '$person', '$admin')";

        if ($conn->query($sql) === TRUE) {
            // Insert an entry into the "activity_log" table
            $activity_description = "Recorded";
            $activity_query = "INSERT INTO activity_log (pno, particulars, papertype, amount, Edate, status, office, comments, Eno, PRno, PRdate, POno, POdate, person, admin, timestamp, activity_description)
            VALUES (NOW(), '$particulars', '$papertype', '$amount', '$Edate', '$status', '$office', '$comments', '$Eno', '$PRno', '$PRdate', '$POno', '$POdate', '$person', '$admin', NOW(), '$activity_description')";

            if ($conn->query($activity_query) === TRUE) {
                // Insert data into "future" table if no files were uploaded
                $future_query = "INSERT INTO future (pno, particulars, amount, taon, resp_center, account_type)
                VALUES (NOW(), '$particulars', '$amount', '$taon', '$resp_center', '$account_type')";

                if ($conn->query($future_query) !== TRUE) {
                    echo "Error inserting into future table: " . $conn->error;
                    // Handle the error here
                }

                header("Location: admin.php");
                exit();
            } else {
                echo "Error inserting activity log: " . $conn->error;
            }
        } else {
            echo "Error inserting into details: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "Form submission error.";
}
?>
