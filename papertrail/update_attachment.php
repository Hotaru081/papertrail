<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: admin.php"); // Redirect to the login page or another appropriate page
    exit();
}

// Check if the user is an admin
if ($_SESSION['role'] !== 'admin') {
    die("Unauthorized access"); // Display an error message and terminate the script if the role is not 'admin'
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Attachment</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="images/batangas.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .container{
            width: 50%;
            padding: 20px;
            background-color: white;
        }
    </style>
</head>
<body>

<?php
include('connection.php');

// Check if the 'pno' and 'timestamp' query parameters are set
if (isset($_GET['pno']) && isset($_GET['timestamp'])) {
    $pno = $_GET['pno'];
    $timestamp = $_GET['timestamp'];

    // Fetch details for the selected attachment
    $details_query = mysqli_query($conn, "SELECT particulars, papertype FROM attachments WHERE pno = '$pno' AND timestamp = '$timestamp'");
    $details_row = mysqli_fetch_array($details_query);
    $particulars = $details_row['particulars'];
    $papertype = $details_row['papertype'];
?>



    <div class="container">
    <h2>Update Attachment</h2>  

    <form action="update_data.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="pno" value="<?php echo $pno; ?>">
        <input type="hidden" name="timestamp" value="<?php echo $timestamp; ?>">
        <input type="hidden" name="particulars" value="<?php echo $particulars; ?>" required><br>

        <label for="papertype">Paper Type:</label>
        <input type="text" name="papertype" value="<?php echo $papertype; ?>" required><br>

        <label for="new_files">New Files (Image/PDF):</label>
        <input type="file" name="new_files[]" multiple accept="image/*,application/pdf"><br>

        <input type="submit" value="Update">
        <button onclick="window.location.href='attachment.php'" class="back-button">Back</button>
    </form>
    </div>

<?php
} else {
    echo 'Invalid request. Please provide valid parameters.';
}
?>

</body>
</html>
