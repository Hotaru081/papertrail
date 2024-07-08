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
<?php
include('connection.php');

// Initialize variables
$office = '';
$status = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['office']) && $_POST['office'] != '') {
        $office = $_POST['office'];
    }

    if (isset($_POST['status']) && $_POST['status'] != '') {
        $status = $_POST['status'];
    }
}

// Build the SQL query based on the filters
if (!empty($office) && !empty($status)) {
    $query = "SELECT * FROM details WHERE office = '$office' AND status = '$status' ORDER BY timestamp DESC";
} elseif (!empty($office)) {
    $query = "SELECT * FROM details WHERE office = '$office' ORDER BY timestamp DESC";
} elseif (!empty($status)) {
    $query = "SELECT * FROM details WHERE status = '$status' ORDER BY timestamp DESC";
} else {
    $query = "SELECT * FROM details ORDER BY timestamp DESC";
}

$result = mysqli_query($conn, $query);

?>


<!DOCTYPE html>
<html>

<style>

body {
    overflow: hidden;
    font-family: Arial, sans-serif;
}

.navbar {
    position: fixed;
    width: 100%;
    z-index: 3; /* Ensure the navbar is above the modal */
    /* Your other navbar styles */
}

.modal-dialog {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    margin-top: 140px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.toggle-password {
        position: relative;
        margin-left: -30px;
        cursor: pointer;
    }

    .toggle-password i {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        color: #777;
        cursor: pointer;
    }

    .hover-link{
    text-decoration: none; 
    color: #fff; cursor: 
    pointer; transition: color 0.1s ease;
}

.hover-link:hover {
    color: dimgray; /* Text color on hover */
}

/* for actionnnn */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-button {
    background-color: transparent;
    color: black;
    padding: 6px 10px;
    border: none;
    cursor: pointer;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 120px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    margin-top: -30px;
}

.dropdown-content a {
    color: black;
    padding: 8px 10px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #283a49;
    color: white;
    width: 100px;
}
        /* Show the dropdown content when the dropdown button is hovered */
.dropdown-button:hover + .dropdown-content {
    display: block;
    }

.dropdown-content a {
    width: 100%;
}
.dropdown-button::after {
    content: "\f107"; 
    font-family: FontAwesome; 
    margin-left: 5px; 
}       

.dropdown-item {
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    color: #333;
    }

#imageModal {
    display: none;
    position: fixed;
    bottom: 0; /* Position the modal at the bottom of the screen */
    left: 0;
    width: 100%;
    height: 120vh;
    z-index: 2; /* Set a lower z-index to ensure the modal is below the navbar */
    background-color: transparent;
    padding: 20px;
    cursor: auto;
    overflow-x: auto;
    padding-left: 600px;
    top: -180px;
}

#modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 2; /* Set the overlay z-index above the modal and below the navbar */
    cursor: pointer;
}
.month-row {
    background-color: pink;
    /* Add any other styling you want for month rows */
}
.week-row {
    background-color: #fdfd96;
    /* Add any other styling you want for week rows */
}
.problem-row {
    background-color: #ff6961;
    /* Add any other styling you want for week rows */
}
.completed-row {
    background-color: #BEE5B0;
    /* Add any other styling you want for week rows */
}
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    list-style: none;
    margin: 20px;

}

.pagination a {
    padding: 5px 10px;
    text-decoration: none;
    margin: 0 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #333;
    color: white;
}

.current-page {
    padding: 5px 10px;
    background-color: #007BFF;
    color: #fff;
    border-radius: 5px;
}

</style>

<head>
    <title>PTCAO</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="images/batangas.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<nav class="navbar" style="display: flex; align-items: center; justify-content: space-between;">
        <div class="navbar-left" style="display: flex; align-items: center; margin-left: 10px">
        <img src="images/batangas.png" style="width: 25px; margin-right: 10px; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3); border-radius: 50%">
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="font-size: 1.5rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);" >Filtered Data:</li>
        </ul>
        </div>

        <div class="navbar-admin" style="box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3); visibility: hidden" >

            <button id="logout-popup-button" class="btn"><img src="images/nobg.png" alt="" style="width: 25px;"></button>
        </div>
    </nav>

    <form action="filter3.php" method="POST">
    <div class="row">
    <select name="office" class="form-select">
                <option value="" disabled="" selected="">OFFICE</option>
                <option value="PTCAO" <?= isset($_POST['office']) && $_POST['office'] == 'PTCAO' ? 'selected' : '' ?>>PTCAO</option>
                <option value="GSO" <?= isset($_POST['office']) && $_POST['office'] == 'GSO' ? 'selected' : '' ?>>GSO</option>
                <option value="OPG" <?= isset($_POST['office']) && $_POST['office'] == 'OPG' ? 'selected' : '' ?>>OPG</option>
                <option value="ANDMIN" <?= isset($_POST['office']) && $_POST['office'] == 'ANDMIN' ? 'selected' : '' ?>>ADMIN</option>
                <option value="BUDGET" <?= isset($_POST['office']) && $_POST['office'] == 'BUDGET' ? 'selected' : '' ?>>BUDGET</option>
                <option value="ACCOUNTING" <?= isset($_POST['office']) && $_POST['office'] == 'ACCOUNTING' ? 'selected' : '' ?>>ACCOUNTING</option>
                <option value="PTO" <?= isset($_POST['office']) && $_POST['office'] == 'PTO' ? 'selected' : '' ?>>PTO</option>
                <option value="PHRMO" <?= isset($_POST['office']) && $_POST['office'] == 'PHRMO' ? 'selected' : '' ?>>PHRMO</option>
                <option value="BAC" <?= isset($_POST['office']) && $_POST['office'] == 'BAC' ? 'selected' : '' ?>>BAC</option>
                <option value="PPDO" <?= isset($_POST['office']) && $_POST['office'] == 'PPDO' ? 'selected' : '' ?>>PPDO</option>
                <option value="PDRRMO" <?= isset($_POST['office']) && $_POST['office'] == 'PDRRMO' ? 'selected' : '' ?>>PDRRMO</option>
                <option value="PSWDO" <?= isset($_POST['office']) && $_POST['office'] == 'PSWDO' ? 'selected' : '' ?>>PSWDO</option>
                <option value="SUPPLIER/CONTRACTOR" <?= isset($_POST['office']) && $_POST['office'] == 'SUPPLIER/CONTRACTOR' ? 'selected' : '' ?>>SUPPLIER/CONTRACTOR</option>
            </select>
        
        <select name="status" class="form-select">
                <option value="" disabled="" selected="">STATUS</option>
                <option value="Pending" <?= isset($_POST['status']) && $_POST['status'] == 'Pending' ? 'selected' : '' ?>>PENDING</option>
                <option value="Complete" <?= isset($_POST['status']) && $_POST['status'] == 'Complete' ? 'selected' : '' ?>>COMPLETE</option>
                <option value="Signed" <?= isset($_POST['status']) && $_POST['status'] == 'Signed' ? 'selected' : '' ?>>SIGNED</option>
                <option value="Problem" <?= isset($_POST['status']) && $_POST['status'] == 'Problem' ? 'selected' : '' ?>>PROBLEM</option>
                <option value="Returned" <?= isset($_POST['status']) && $_POST['status'] == 'Returned' ? 'selected' : '' ?>>RETURNED</option>
                <option value="Released" <?= isset($_POST['status']) && $_POST['status'] == 'Released' ? 'selected' : '' ?>>RELEASED</option>
            </select>

            <button type="submit" class="filter">Filter</button>
            <a href="admin.php" class="reset" >Reset</a>
            
        </div>

    </div>  
</form>

<!--
<button class="adbtn" id="add-button" style="margin-top: -13px;">Record</button>
-->

    <!-- Modal -->
    <div id="modal" class="modal" >
        <div class="modal-content" style="height: 62vh; width: 90%; max-width: 700px; margin-top: 10%;">
            <span class="close" id="modal-close">&times;</span>
            <h2 style="text-align: center; font-size: 30px; margin-top: -2px">RECORD NEW</h2>

            <div class="form-group" style="margin-top: 10px">
            <form action="process.php" method="post" enctype="multipart/form-data"> 
                <label class="lbl_ad" style="font-size: 20px; font-weight: bold;" for="particulars">PARTICULARS:</label><br>
                <input style="width: 267%; font-size: 20px; margin-bottom: 5px" class="ad" type="text" name="particulars" required>
            </div><br>

            <div class="form-group">
                <label style="margin-top: 5px; font-size: 20px; font-weight: bold" class="lbl_ad" for="papertype">PAPERTYPE:</label><br>
                <select style="width: 331px; font-size: 20px; margin-bottom: 5px" class="ad" name="papertype" required>
                    <option value="" disabled="" selected="">-----</option>
                    <option value="Project Proposal">PROJECT PROPOSAL</option>
                    <option value="Project Brief">PROJECT BRIEF</option>
                    <option value="Emanating">EMANATING</option>
                    <option value="Purchase Request">PURCHASE REQUEST</option>
                    <option value="Earmark/Budget Certification">EARMARK/BUDGET CERTIFICATION</option>
                    <option value="Purchase Order">PURCHASE ORDER</option>
                    <option value="Reueest for Inspection">REQUEST FOR INSPECTION</option>
                    <option value="Inspection and Acceptance">INSPECTION AND ACCEPTANCE(AIP)</option>
                    <option value="Waste Materials">WASTE MATERIALS</option>

                    <optgroup label="Voucher">
                        <option value="VOUCHER - Salary">SALARY</option>
                        <option value="VOUCHER - RA">RA</option>
                        <option value="VOUCHER - RATA">RATA</option>
                        <option value="VOUCHER - Benefits">BENEFITS</option>
                        <option value="VOUCHER - Subsidy">SUBSIDY</option>
                        <option value="VOUCHER - Honorarium">HONORARIUM</option>
                        <option value="VOUCHER - Prizes">PRIZES</option>
                    </optgroup>

                    <optgroup label="Payroll">
                        <option value="PAYROLL - Salary Permanent">SALARY PERMANENT</option>
                        <option value="PAYROLL - Salary Casual">SALARY CASUAL</option>
                        <option value="PAYROLL - Salary JO">SALARY JO</option>
                        <option value="PAYROLL - Benefits">BENEFITS</option>
                    </optgroup>

                    <option value="Certifications">CERTIFICATIONS</option>
                    <option value="Comms. & Indorsement">COMMS. & INDORSMENT</option>
                    <option value="Attendance Sheet">ATTENDANCE SHEET</option>
                    <option value="PPMP">PPMP</option>
                    <option value="PPMP - Addendum">PPMP - ADDENDUM</option>
                    <option value="PAAR">PAAR</option>
                    <option value="AIP">AIP</option>

                    <optgroup label="HR Files">
                        <option value="HR Files - PDS">PDS</option>
                        <option value="HR Files - IPCR">IPCR</option>
                        <option value="HR Files - SALN">SALN</option>
                        <option value="HR Files - IDP">IDP</option>
                        <option value="HR Files - Assumption">ASSUMPTION</option>
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold" class="lbl_ad" for="amount">AMOUNT:</label><br>
                <input style="width:350px; font-size: 20px" class="ad" type="number" name="amount" step="0.01" required>
            </div><br>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold" class="lbl_ad" for="Edate">EVENT DATE:</label><br>
                <input style="width: 227.7px; padding-top: 4px; padding-bottom: 3px; font-size: 20px" type="date" id="date" name="Edate" required>
            </div>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold" class="lbl_ad" for="status">STATUS:</label><br>
                <select style="width: 227.7px; font-size: 20px; margin-bottom: 5px" class="ad" name="status" required> 
                    <option value="Pending">PENDING</option> 
                    <option value="Released">RELEASED</option>
                    <option value="Returned">RETURNED</option>
                    <option value="Signed">SIGNED</option>
                    <option value="Problem">PROBLEM</option>
                    <option value="Complete">COMPLETE</option>
                </select>
            </div>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold" class="lbl_ad" for="office">OFFICE:</label><br>
                <select style="width: 230px; font-size: 20px" class="ad" name="office" required>
                    <option value="PTCAO">PTCAO</option>
                    <option value="OPG">OPG</option>
                    <option value="ADMIN">ADMIN</option>
                    <option value="BUDGET">BUDGET</option>
                    <option value="ACCOUNTING">ACCOUNTING</option>
                    <option value="PTO">PTO</option>
                    <option value="PHRMO">PHRMO</option>
                    <option value="GSO">GSO</option>
                    <option value="BAC">BAC</option>
                    <option value="PPDO">PPDO</option>
                    <option value="PDDRMO">PDRRMO</option>
                    <option value="PSWDO">PSWDO</option>
                </select>
            </div>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold" class="lbl_ad" class="lbl_ad" for="comments">COMMENTS:</label><br>
                <input style="width: 269%; font-size: 20px; margin-bottom: 20px; border-radius: 3px; border-bottom: 3px solid #333; border-top: 1px solid #333; border-right: 1px solid #333; border-left: 1px solid #333" class="ad" type="text" name="comments" step="0.01">
            </div><br>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold" class="lbl_ad" class="lbl_ad" for="Eno">EMANATE NO.:</label><br>
                <input style="width: 220.7px; font-size: 20px" class="ad" type="text" name="Eno" step="0.01" required>
            </div>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold;" class="lbl_ad" for="PRNO">PR NO.:</label><br>
                <input style="width: 209px; font-size: 20px; margin-bottom: 5px" class="ad" type="number" name="PRno" step="0.01" >
            </div>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold" class="lbl_ad" for="PRdate">PR DATE:</label><br>
                <input style="width: 224px; padding-top: 4px; padding-bottom: 3px; font-size: 20px" type="text" id="PRdate" name="PRdate" placeholder="MM-DD-YYYY">
            </div>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold" class="lbl_ad" for="POno">PO NO.:</label><br>
                <input style="width: 330px; font-size: 20px; margin-bottom: 5px" class="ad" type="number" name="POno" step="0.01">
            </div>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold" class="lbl_ad" for="POdate">PO DATE:</label><br>
                <input style="width: 343px; padding-top: 4px; padding-bottom: 3px; font-size: 20px; " type="text" id="POdate" name="POdate" placeholder="MM-DD-YYYY">
            </div>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold" class="lbl_ad" for="person">LAST TOUCHED:</label><br>
                <input class="ad" style="width: 227.7px; font-size: 20px" type="text" name="person" step="0.01" required>
            </div>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold" class="lbl_ad" for="admin">ADMIN:</label><br>
                <input class="ad" style="width: 227.7px; font-size: 20px; margin-bottom: 5px" type="text" name="admin" step="0.01" value="<?php echo $username; ?>" required>
            </div>

            <div class="form-group">
                <label style="font-size: 20px; font-weight: bold" class="lbl_ad" for="image">FILE:</label><br>
                <input class="ad" style="width: 194.5px; border: 1px solid #333; border-radius: 3px; padding-top:7px; padding-bottom: 5px" type="file" name="image" step="0.01">
            </div>


            <div class="form-group">
                <input class="adsub" style="width: 700px; font-size: 20px; padding-top: 5px; padding-bottom: 5px; background-color: #333; color: white; border-radius: 5px; margin-top: 5px" type="submit" name= "submit" value="Submit">
            </div>
            </form>
        </div>
    </div>



<!-- SEARCH -->
<div class="rec_sch"> 
    <form action="search_filter3.php" method="GET" class="srch" style="margin-top: 20px;">
        <input class="inp_sch" type="text" name="query" placeholder="Enter your search term">
        <input class="btn_sch" type="submit" value="Search">
    </form></div>

<!-- Display filtered rows -->
<br>
<div class="tabs scroll-content" style=" margin-top: 100px; height: 720px ">
		<table style="border: 1px;" class="table">
			<thead class="tabs_name" style="font-size: 13px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                <th style="width: 7%;">ACTIONS</th>
				<th style="width: 20%; ">PARTICULARS</th>
				<th>PAPERTYPE</th>
                <th>AMOUNT</th>
                <th>EVENT DATE</th>
                <th>STATUS</th>
                <th>OFFICE</th>
                <th style="width: 10%; ">COMMENTS</th>
                <th>EMANATE NO.</th>
                <th>PR NO.</th>
                <th>PR DATE</th>
                <th>PO NO.</th>
                <th>PO DATE</th>
                <th>PERSON</th>
                <th>ADMIN</th>
                <th>DATE UPDATE</th>
			</thead>
			<tbody>
            <?php
                include('connection.php');

                while ($row = mysqli_fetch_array($result)) {
                    $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
                    $oneMonthAgo = date('Y-m-d', strtotime('-1 month'));
                
                    // Calculate age in seconds
                    $ageInSeconds = time() - strtotime($row['timestamp']);
                
                    if ($row['status'] === 'Problem') {
                        // If status is 'problem', set the row to have a red background
                        echo '<tr class="problem-row">';
                    } elseif ($row['status'] === 'Complete') {
                        // If status is 'completed', set the row to have a green background
                        echo '<tr class="completed-row">';
                    } elseif ($ageInSeconds > 30 * 24 * 60 * 60) {
                        // Rows updated more than a month ago
                        echo '<tr class="month-row">';
                    } elseif ($ageInSeconds > 7 * 24 * 60 * 60) {
                        // Rows updated more than 7 days ago
                        echo '<tr class="week-row">';
                    } else {
                        echo '<tr>';
                    }
                    ?>
                        
                        <td>
                            <a href="update.php?pno=<?php echo $row['pno']; ?>" style="font-size: 13px; margin-left: 20px; text-decoration: none; color: black; font-weight: bold">Update <i class="fas fa-edit fa-sm" style="margin-left: 5px; color: #2667a0"></i></a>
                            <a href="attachment.php?pno=<?php echo $row['pno']; ?>" style="font-size: 13px; margin-left: 20px; text-decoration: none; color: black; font-weight: bold">Attachment<i class="fas fa-paperclip fa-sm" style="margin-left: 5px; color: #2667a0"></i></a>
                            <a href="checklist_filter3.php?id=<?php echo $row['id']; ?>" style="font-size: 13px; margin-left: 20px; text-decoration: none; color: black; font-weight: bold">Checklist<i class="fas fa-check-square fa-sm" style="margin-left: 5px; color: green"></i></a>
                            <?php
                            @session_start(); // Start the session (if not started already)

                            // Check if the user is logged in and is an admin (you'll need to replace 'admin_username' with your actual admin username)
                            if (isset($_SESSION['username']) && $_SESSION['username'] === 'KikoAdmin') {
                                // Assuming $row['pno'] contains the necessary information for the link
                                if (isset($row['pno'])) {
                                    // Display the link for the admin user with a confirmation alert
                                    echo '<a href="delete_row_filter3.php?pno=' . $row['pno'] . '" onclick="return confirm(\'Are you sure you want to delete this row?\')" style="font-size: 13px; margin-left: 20px; text-decoration: none; color: black; font-weight: bold">Delete<i class="fas fa-trash-alt" style="color: red; margin-left: 5px"></i></a>';
                                }
                            }
                            ?>
                            </td>
                        <td style="padding-left: 10px">
                            <a href="activity_log_admin.php?pno=<?php echo $row['pno']; ?>" style="color: #126dbc; text-decoration: none; margin-left: 5px; padding-right: 10px">
                                <?php echo $row['particulars']; ?>
                            </a>
                        </td>
                        <td style="text-align:center"><?php echo $row['papertype']; ?></td>
                        <td style="text-align:right"><?php $amount = $row['amount'];if ($amount != 0) {echo number_format($amount, 2);}?></td>
                        <td style="text-align:center"><?php echo $row['Edate']; ?></td>
                        <td style="text-align:center"><?php echo $row['status']; ?></td>
                        <td style="text-align:center; font-size: 13px;"><?php echo $row['office']; ?></td>
                        <td style="text-align:center; font-size: 13px;"><?php echo $row['comments']; ?></td>
                        <td style="text-align:center; font-size: 13px"><?php echo $row['Eno']; ?></td>
                        <td style="text-align:center; font-size: 13px"><?php echo $row['PRno']; ?></td>
                        <td style="text-align:center; font-size: 13px"><?php echo $row['PRdate']; ?></td>
                        <td style="text-align:center; font-size: 13px;"><?php echo $row['POno']; ?></td>
                        <td style="text-align:center; font-size: 13px"><?php echo $row['POdate']; ?></td>
                        <td style="text-align:center; font-size: 13px;"><?php echo $row['person']; ?></td>
                        <td style="text-align:center; font-size: 13px;"><?php echo $row['admin']; ?></td>
                        <td style="text-align:center; font-size: 13px;"><?php echo date('m/d/Y h:i A', strtotime($row['timestamp'])); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <div style="display: inline-block; position: absolute; right: 20px;">
    <a href="programmers.php"><p style="display: inline-block; color: #2667a0"><u>2023</u></p></a>
    <a href="programmers.php" style="display: inline-block; "><img src="images/copyright.png" style=" width: 15px; ; "></a>
    </div>

    <div id="imageModal" class="modal">
    <span class="close" onclick="closeImageModal()">&times;</span>
    <img class="modal-content" id="modalImage">
    </div>

    <div id="modal-overlay"></div>

<!-- LOGOUT -->
<div id="logout-popup" class="popup">
        <div class="popup-content" style="width: 250px; height: 180px; text-align: center; justify-content: center;">
            <span class="close" id="logout-close">&times;</span>
            <h2>Logout</h2>
            <h3 style="margin-top: -15px">Confirmation</h3>
            <p style="color: #EE4B2B;">Are you sure you want to logout?</p>
            <form action="logout_process.php" method="post">
                <input type="submit" value="Logout" style="width: 100%; padding: 10px; margin-top: 10px; background-color: #333; color: white; border-radius: 5px;">
            </form>
        </div>
    </div>

    <script src="js/admin.js"></script>
    <script>
        function showImage(imageSrc) {
    var modal = document.getElementById("imageModal");
    var modalImg = document.getElementById("modalImage");
    modal.style.display = "block";
    modalImg.src = "./images/" + imageSrc;

    // Add an event listener to close the modal when clicking outside
    window.addEventListener("click", function (event) {
        if (event.target == modal) {
            closeImageModal();
        }
    });
}

function closeImageModal() {
    var modal = document.getElementById("imageModal");
    modal.style.display = "none";
}

var lastScrollTop = 0;

document.addEventListener("click", function (event) {
    // Close the dropdown if the clicked element is not the dropdown button or inside the dropdown
    if (!event.target.matches('.dropdown-button') && !event.target.closest('.dropdown-content')) {
        closeDropdowns();
    }
});

document.addEventListener("wheel", function (event) {
    // Close the dropdown when scrolling down or up
    if (event.deltaY !== 0) {
        closeDropdowns();
    }
});

function toggleDropdown(button) {
    var dropdown = button.nextElementSibling;
    dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
}

function closeDropdowns() {
    var dropdowns = document.getElementsByClassName('dropdown-content');
    for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.style.display === 'block') {
            openDropdown.style.display = 'none';
        }
    }
}


    </script>
</body>
</html>
