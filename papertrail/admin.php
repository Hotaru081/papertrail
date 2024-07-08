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

<style>

body {
    font-family: Arial, sans-serif;
}

.navbar {
    position: fixed;
    width: 100%;
    z-index: 3; /* Ensure the navbar is above the modal */
    /* Your other navbar styles */
}

    .form-group {
    display: inline-block;
    margin-bottom: 5px;
}

.lbl_ad {
    font-size: 20px;
}

.ad {
    padding: 10px;
    font-size: 15px;
}

/*
.dropdown {
    position: relative;
    display: inline-block;
}

.dropbtn {
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
}

.dropdown-content a {
    color: black;
    padding: 8px 10px;
    text-decoration: none;
    display: block;
}
.dropdown-content a:hover {
    background-color: #333;
    color: white;
}
.dropdown:hover .dropdown-content {
    display: block;
}
.dropdown-content a {
    width: 100%;
}
.dropbtn::after {
    content: "\f107"; 
    font-family: FontAwesome; 
    margin-left: 5px; 
}       

*/

.form-group{
    display: inline-block;
}

.lbl_ad{
    font-size: 10px;
}

.ad{
    padding: 5px;
    font-size: 15px;
}

.hover-link{
    text-decoration: none; 
    color: #fff; cursor: 
    pointer; transition: color 0.1s ease;
}

.hover-link:hover {
    color: #283a49; /* Text color on hover */
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
    box-shadow: -10px 10px 16px 0px rgba(0, 0, 0, 0.2);
    margin-top: -30px;
}

.dropdown-content a {
    color: black;
    padding: 8px 1px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #283a49;
    color: white;
}
        /* Show the dropdown content when the dropdown button is hovered */
        .dropdown-button:hover + .dropdown-content,
.dropdown-content:hover {
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

.dropdown-content:hover {
    display: block;
    min-width: 120px; 
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
    background-color: #2667a0;
    color: white;
}

.current-page {
    padding: 5px 10px;
    background-color: #007BFF;
    color: #fff;
    border-radius: 5px;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Adjust the alpha (last value) for transparency */
    z-index: -1; /* Place the overlay behind the modal content */
    
}

.modal{
    position: relative;
}

.modal-content {
    background: #fff; /* Background color of the modal content */
    border-radius: 5px;
    box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1; /* Place the modal content in front of the overlay */
}

.separator {
    border: none; /* Remove default border */
    border-top: 2px solid #000; /* Specify the thickness and color of the line */
    margin: 10px 0; /* Adjust margin to control the spacing around the separator */
    margin-bottom: 20px;
}


</style>


<head>
    <title>PTCAO</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="images/batangas.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>
<body>
    <nav class="navbar" style="display: flex; align-items: center; justify-content: space-between;">
        <div class="navbar-left" style="display: flex; align-items: center; margin-left: 10px">
        <img src="images/batangas.png" style="width: 25px; margin-right: 10px; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3); border-radius: 50%">
        <ul style="list-style: none; padding: 0; margin: 0; ">
            <li style="font-size: 1.5rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);" ><a href="home2.php" class="hover-link">PTCAO PAPERTRAIL</a></li>
        </ul>
        </div>

        <div class="navbar-admin" style="box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3);">
                <p>Welcome, <b><u><?php echo $username; ?>!</u></b></p>
                <button id="logout-popup-button" class="btn">
                <img src="images/nobg.png" alt="" style="width: 25px;">
            </button>
        </div>
    </nav>

    <div id="logout-popup" class="popup">
        <div class="popup-content" style="width: 250px; height: 190px; text-align: center; justify-content: center;">
            <span class="close" id="logout-close">&times;</span>
            <h2>Logout</h2>
            <h3 style="margin-top: -15px">Confirmation</h3>
            <p style="color: #EE4B2B; font-weight: bold">Are you sure you want to logout?</p>
            <form action="logout_process.php" method="post">
                <input type="submit" value="Logout" style="width: 100%; padding: 10px; margin-top: 3px; background-color: #2667a0; color: white; border-radius: 5px; cursor: pointer">
            </form>
        </div>
    </div>

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
</form>

<button class="adbtn" id="add-button" style="margin-top: -13px;">Record</button>
<button class="adbtn" id="add-button" style="margin-top: -13px; margin-left: 90px;" onclick="window.location.href='tracker.php';">Tracker</button>
<?php
session_start(); // Start the session to access user data


if ($_SESSION['username'] === 'KikoAdmin') {
    echo '<button onclick="window.location.href=\'add_account.php\'" class="adbtn" id="add-account-button" style="margin-top: -13px; margin-left: 180px;">Add Account</button>';
}
?>

    <div class="rec_sch"> 
        </ul>
        <form class="srch" action="search.php" method="GET" style="margin-top: 20px;">
        <input class="inp_sch" type="text" name="query" placeholder="Enter your search term">
        <input class="btn_sch" type="submit" value="Search" >
        </form>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-overlay" data-close-modal></div>
        <div class="modal-content" style="height: 77vh; width: 90%; max-width: 700px; margin-top: 5%;">
            <h2 style="text-align: center; font-size: 30px; margin-top: -2px; color: #2667a0">RECORD NEW</h2>
            <span class="close" id="modal-close" style="visibility: hidden;">&times;</span>
            <div class="form-group" style="margin-top: 10px">
            <form action="process.php" method="post" enctype="multipart/form-data"> 
                <label class="lbl_ad" style="font-size: 20px;" for="particulars">PARTICULARS:</label><br>
                <input style="width: 267%; font-size: 20px" class="ad" type="text" name="particulars" required>
            </div><br>

            <div class="form-group">
                <label style="margin-top: 5px; font-size: 20px;" class="lbl_ad" for="papertype">PAPERTYPE:</label><br>
                <select style="width: 331px; font-size: 20px" class="ad" name="papertype" required>
                    <option value="Others">Others</option>
                    <option value="Emanating">EMANATING</option>
                    <option value="Purchase Request">PURCHASE REQUEST</option>
                    <option value="Earmark/Budget Certification">EARMARK/BUDGET CERTIFICATION</option>
                    <option value="Purchase Order">PURCHASE ORDER</option>
                    <option value="Quotations">QUOTATIONS</option>
                    <option value="Reueest for Inspection">REQUEST FOR INSPECTION</option>
                    <option value="Inspection and Acceptance">INSPECTION AND ACCEPTANCE(AIP)</option>
                    <option value="Waste Materials">WASTE MATERIALS</option>
                    <option value="PR Voucher">PR VOUCHER</option>
                    <option value="Project Proposal">PROJECT PROPOSAL</option>
                    <option value="Project Brief">PROJECT BRIEF</option>
                    <option value="Work Program">WORK PROGRAM</option>
                    <option value="PPMP">PPMP</option>
                    <option value="PPMP - Addendum">PPMP - ADDENDUM</option>
                    <option value="Certifications">CERTIFICATIONS</option>
                    <option value="Voucher">VOUCHER</option>

                    <optgroup label="Voucher">
                        <option value="VOUCHER - Salary">SALARY</option>
                        <option value="VOUCHER - RA">RA</option>
                        <option value="VOUCHER - RATA">RATA</option>
                        <option value="VOUCHER - Benefits">BENEFITS</option>
                        <option value="VOUCHER - Subsidy">SUBSIDY</option>
                        <option value="VOUCHER - Honorarium">HONORARIUM</option>
                        <option value="VOUCHER - Prizes">PRIZES</option>
                    </optgroup>

                    <option value="Payroll">PAYROLL</option>

                    <optgroup label="Payroll">
                        <option value="PAYROLL - Salary Permanent">SALARY PERMANENT</option>
                        <option value="PAYROLL - Salary Casual">SALARY CASUAL</option>
                        <option value="PAYROLL - Salary JO">SALARY JO</option>
                        <option value="PAYROLL - Benefits">BENEFITS</option>
                    </optgroup>

                    <option value="Certifications">CERTIFICATIONS</option>
                    <option value="Comms. & Indorsement">COMMS. & INDORSMENT</option>
                    <option value="Attendance Sheet">ATTENDANCE SHEET</option>
                    <option value="PAAR">PAAR</option>
                    <option value="HR Files">HR FILES</option>

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
                <label style="font-size: 20px;" class="lbl_ad" for="amount">AMOUNT:</label><br>
                <input style="width:350px; font-size: 20px" class="ad" type="number" name="amount" step="0.01">
            </div><br>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" for="Edate">EVENT DATE:</label><br>
                <input style="width: 224px; padding-top: 5px; padding-bottom: 4px; font-size: 20px" type="text" id="Edate" name="Edate" placeholder="MM-DD-YYYY">
            </div>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" for="status">STATUS:</label><br>
                <select style="width: 227.7px; font-size: 20px" class="ad" name="status" required> 
                    <option value="Pending">PENDING</option> 
                    <option value="Released">RELEASED</option>
                    <option value="Returned">RETURNED</option>
                    <option value="Signed">SIGNED</option>
                    <option value="Problem">PROBLEM</option>
                    <option value="Complete">COMPLETE</option>
                </select>
            </div>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" for="office">OFFICE:</label><br>
                <select style="width: 230px; font-size: 20px" class="ad" name="office" required>
                    <option value="PTCAO">PTCAO</option>
                    <option value="GSO">GSO</option>
                    <option value="OPG">OPG</option>
                    <option value="ADMIN">ADMIN</option>
                    <option value="BUDGET">BUDGET</option>
                    <option value="ACCOUNTING">ACCOUNTING</option>
                    <option value="PTO">PTO</option>
                    <option value="PHRMO">PHRMO</option>
                    <option value="BAC">BAC</option>
                    <option value="PPDO">PPDO</option>
                    <option value="PDDRMO">PDRRMO</option>
                    <option value="PSWDO">PSWDO</option>
                    <option value="SUPPLIER/CONTRACTOR">SUPPLIER/CONTRACTOR</option>
                </select>
            </div>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" class="lbl_ad" for="comments">COMMENTS:</label><br>
                <input style="width: 269%; font-size: 20px; margin-bottom: 20px; border-radius: 3px; border-bottom: 3px solid #333; border-top: 1px solid #333; border-right: 1px solid #333; border-left: 1px solid #333" class="ad" type="text" name="comments" step="0.01">
            </div><br>


            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" class="lbl_ad" for="Eno">EMANATE NO.:</label><br>
                <input style="width: 220.7px; font-size: 20px" class="ad" type="text" name="Eno" step="0.01">
            </div>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" for="PRNO">PR NO.:</label><br>
                <input style="width: 209px; font-size: 20px" class="ad" type="number" name="PRno" step="0.01" >
            </div>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" for="PRdate">PR DATE:</label><br>
                <input style="width: 224px; padding-top: 5px; padding-bottom: 5px; font-size: 20px" type="text" id="PRdate" name="PRdate" placeholder="MM-DD-YYYY">
            </div>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" for="POno">PO NO.:</label><br>
                <input style="width: 330px; font-size: 20px" class="ad" type="number" name="POno" step="0.01">
            </div>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" for="POdate">PO DATE:</label><br>
                <input style="width: 343px; padding-top: 5px; padding-bottom: 5px; font-size: 20px" type="text" id="POdate" name="POdate" placeholder="MM-DD-YYYY">
            </div>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" for="person">LAST TOUCHED:</label><br>
                <select id="personSelect" style="width: 227.7px; font-size: 20px" class="ad" name="person" onchange="checkOtherOption()">
                    <option value="">----</option>
                    <option value="Roger">Roger</option>
                    <option value="Krystel">Krystel</option>
                    <option value="Chona">Chona</option>
                    <option value="Kiko">Kiko</option>
                    <option value="JMC">JMC</option>
                    <option value="Contractor">Contractor</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" for="admin">ADMIN:</label><br>
                <input class="ad" style="width: 227.7px; font-size: 20pxp; margin-bottom: 20px" type="text" name="admin" step="0.01" value="<?php echo isset($newUsername) ? $newUsername : $username; ?>" required>
            </div>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" for="image">FILES:</label><br>
                <input class="ad" style="width: 207.5px; border: 1px solid #333; border-radius: 3px; padding-top:7px; padding-bottom: 5px" type="file" name="image[]" multiple accept=".pdf, .jpg, .jpeg, .png">
            </div>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" class="lbl_ad" for="year">YEAR</label><br>
                <input style="width: 120px; font-size: 20px" class="ad" type="text" name="year" step="0.01">
            </div>

            <div class="form-group">
                <label style="font-size: 20px;" class="lbl_ad" for="resp_center">RC:</label><br>
                <select style="width: 120px; font-size: 20px" class="ad" name="resp_center">
                    <option value="">----</option>
                    <option value="99201">99201</option>
                    <option value="92202">92202</option>
                    <option value="1123">1123</option>
                </select>
            </div>

            <div class="form-group">
                <label style="margin-top: 5px; font-size: 20px; " class="lbl_ad" for="account_type">ACCOUNT TYPE:</label><br>
                <select style="width: 435px; font-size: 15px; padding-top: 9px; padding-bottom: 6px" class="ad" name="account_type">
                <option value="">----</option>
                <optgroup label="1123" >
                <option value="OFFICE SUPPLIES - 50203010">OFFICE SUPPLIES - 50203010</option>
                    <option value="OTHER SUPPLIES & MATERIALS EXPENSE - 50203990">OTHER SUPPLIES & MATERIALS EXPENSE - 50203990</option>
                    <option value="FUEL, OIL AND LUBRICANT - 50203090">FUEL, OIL AND LUBRICANT - 50203090</option>
                    <option value="TELEPHONE EXPENSE - 50205020">TELEPHONE EXPENSE - 50205020</option>
                    <option value="INTERNET & SUBSCRIPTION EXPENSE - 50205030">INTERNET & SUBSCRIPTION EXPENSE - 50205030</option>
                    <option value="OTHER MAINTENANCE & OTHER OPERATION EXPENSE - 50299990">OTHER MAINTENANCE & OTHER OPERATION EXPENSE - 50299990</option>
                </optgroup>

                <optgroup label="REPAIR & MAINTENANCE">
                    <option value="RM - BUILDING & OTHER STRUCTURE - 10704010">RM - BUILDING & OTHER STRUCTURE - 10704010</option>
                    <option value="RM - MACHINERY & EQUIPMENT - 50213050">RM - MACHINERY & EQUIPMENT - 50213050</option>
                    <option value="RM - TRANSPORTATION - 50212060">RM - TRANSPORTATION - 50212060</option>
                    <option value="RM - FURNITURE & FIXTURES - 50213070">RM - FURNITURE & FIXTURES - 50213070</option>
                    <option value="SUBSCRIPTION EXPENSE - 50299070">SUBSCRIPTION EXPENSE - 50299070</option>
                    <option value="POSTAGE & COURIER SERVICE - 50205010">POSTAGE & COURIER SERVICE - 50205010</option>
                    <option value="TAXES, DUTIES & LICENSES - 50216010">TAXES, DUTIES & LICENSES - 50216010</option>
                    <option value="INSURANCE EXPENSES - 50216030">INSURANCE EXPENSES - 50216030</option>
                </optgroup>

                <optgroup label="99201/92202">
                    <option value="TRAVELLING EXPENSES - 50201010">TRAVELLING EXPENSES - 50201010</option>
                    <option value="TRAINING EXPENSES - 50202010">TRAINING EXPENSES - 50202010</option>
                    <option value="REPRESENTATION EXPENSES - 50299030">REPRESENTATION EXPENSES - 50299030</option>
                    <option value="PRIZES - 50206020">PRIZES - 50206020</option>
                    <option value="OTHER PROFESSIONAL SERVICES - 50211990">OTHER PROFESSIONAL SERVICES - 50211990</option>
                    <option value="SUBSIDY TO LGO - 50214030">SUBSIDY TO LGO - 50214030</option>
                    <option value="ADVERTISING EXPENSES - 50299010">ADVERTISING EXPENSES - 50299010</option>
                    <option value="PRINTING & PUBLIC EXPENSES - 50299020">PRINTING & PUBLIC EXPENSES - 50299020</option>
                    <option value="RENT EXPENSES - 50299050">RENT EXPENSES - 50299050</option>
                    <option value="CONSULTANCY EXPENSES - 50211030">CONSULTANCY EXPENSES - 50211030</option>
                </optgroup>

                <optgroup label="CAPITAL OUTLAY">
                    <option value="CA - ICT EQUIPMENT - 10705030">CA - ICT EQUIPMENT - 10705030</option>
                    <option value="CA - COMMUNICATION EQUIPMENT - 10705070">CA - COMMUNICATION EQUIPMENT - 10705070</option>
                    <option value="CA - OFFICE EQUIPMENT - 10705020">CA - OFFICE EQUIPMENT - 10705020</option>
                    <option value="CA - FURNITURE & FIXTURES - 10707010">CA - FURNITURE & FIXTURES - 10707010</option>
                    <option value="CA - MILITARY, POLICE & SECURITY EQUIPMENT - 10705100">CA - MILITARY, POLICE & SECURITY EQUIPMENT - 10705100</option>
                    <option value="OTHER MACHINERY & EQUIPMENT - 10705990">OTHER MACHINERY & EQUIPMENT - 10705990</option>
                </optgroup>
                </select>
            </div>

            <div class="form-group">
                <input class="adsub" style="width: 700px; font-size: 20px; padding-top: 5px; padding-bottom: 5px; background-color: #2667a0; color: white; border-radius: 5px; margin-top: 5px; margin-bottom: 5px" type="submit" name= "submit" value="Submit">
            </div>

            <div style="margin-top: 5px;">
            <a href="admin.php" style=" color: black; text-decoration: none; background-color: transparent; padding: 7px; padding-left: 47.2%; padding-right: 47.2%; border-radius: 4px; border: 2px solid black;">Back</a>
			</div>

            </form>
        </div>
    </div>

	<br>
	<div class="tabs scroll-content" style="overflow: auto" >
		<table style="border: 1px;" class="table">
			<thead class="tabs_name" style="font-size: 13px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                <th style="width: 7%;">ACTIONS</th>
				<th style="width: 20%; ">PARTICULARS</th>
				<th>PAPERTYPE</th>
                <th>AMOUNT</th>
                <th>EVENT DATE</th>
                <th>STATUS</th>
                <th>OFFICE</th>
                <th style="width: 10%; " >COMMENTS</th>
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

                $limit = 11; // Number of records per page
                // Check if the page parameter is set, and it's greater than 1
                if (isset($_GET["page"]) && $_GET["page"] > 1) {
                    $page = $_GET["page"];
                    $start_from = ($page - 1) * $limit;
                    $query = mysqli_query($conn, "SELECT * FROM `details` ORDER BY timestamp DESC LIMIT $start_from, $limit");
                } else {
                    // Display page 1 by default
                    $page = 1;
                    $start_from = 0;
                    $query = mysqli_query($conn, "SELECT * FROM `details` ORDER BY timestamp DESC LIMIT $start_from, $limit");
                }

                while ($row = mysqli_fetch_array($query)) {
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
                            <a href="update.php?pno=<?php echo $row['pno']; ?>" style="font-size: 13px; margin-left: 27px; text-decoration: none; color: black; font-weight: bold">Update <i class="fas fa-edit fa-sm" style="margin-left: 7px; color:#2667a0"></i></a>
                            <button class="dropdown-button" style="font-weight: bold; margin-left: 18px" onclick="toggleDropdown(this)">Actions</button>
                            <div class="dropdown-content" style="font-size: 13px; display: none;">
                                <a href="checklist.php?id=<?php echo $row['id']; ?>">Checklist</a>
                                <a class="dropdown-item" href="attachment.php?pno=<?php echo $row['pno']; ?>">Attachment</a>
                                <?php
                                @session_start(); // Start the session (if not started already)

                                // Check if the user is logged in and is an admin (you'll need to replace 'admin_username' with your actual admin username)
                                if (isset($_SESSION['username']) && $_SESSION['username'] === 'KikoAdmin') {
                                    // Assuming $row['pno'] contains the necessary information for the link
                                    if (isset($row['pno'])) {
                                        // Display the link for the admin user with a confirmation alert
                                        echo '<a class="dropdown-item" href="delete_row.php?pno=' . $row['pno'] . '" onclick="return confirm(\'Are you sure you want to delete this row?\')">Delete</a>';
                                    }
                                }
                                ?>
                            </div>
                        </td>
                        <td style="padding-left: 10px">
                            <a href="activity_log_admin.php?pno=<?php echo $row['pno']; ?>" style="color: #126dbc; text-decoration: none; padding-right: 10px">
                                <?php echo $row['particulars']; ?>
                            </a>
                        </td>
                        <td style="text-align:center"><?php echo $row['papertype']; ?></td>
                        <td style="text-align:right"><?php $amount = $row['amount'];if ($amount != 0) {echo number_format($amount, 2);}?></td>
                        <td style="text-align:center"><?php echo $row['Edate']; ?></td>
                        <td style="text-align:center"><?php echo $row['status']; ?></td>
                        <td style="text-align:center; font-size: 13px;"><?php echo $row['office']; ?></td>
                        <td style="text-align:center; font-size: 13px; text-align: justify;"><?php echo $row['comments']; ?></td>
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


    <?php
    // Pagination links
    $sql = "SELECT COUNT(id) FROM details";
    $rs_result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($rs_result);
    $total_records = $row[0];
    $total_pages = ceil($total_records / $limit);

    echo '<ul class="pagination">';

    // Calculate the start and end pages to display
    $startPage = max(1, min($page - 2, $total_pages - 4));
    $endPage = min($total_pages, $startPage + 4);

// Add the left arrow before the first visible page
$prevPage = ($page > 1) ? $page - 1 : $total_pages; // Wrap to last page if on the first page
echo "<li><a href='admin.php?page=" . $prevPage . "'>&lt;</a></li>";

    for ($i = $startPage; $i <= $endPage; $i++) {
        if ($i == $page || ($i == 1 && $page == 0)) {
            $bgColor = ($i == 1) ? 'background-color: #ffcccb;' : '';
            echo "<li class='current'><a href='admin.php?page=" . $i . "'>$i</a></li>";
        } else {
            echo "<li><a href='admin.php?page=" . $i . "'>$i</a></li>";
        }
    }

// Add the right arrow after the last visible page
$nextPage = ($page < $total_pages) ? $page + 1 : 1; // Wrap to page 1 if on the last page
echo "<li><a href='admin.php?page=" . $nextPage . "'>&gt;</a></li>";

    echo '</ul>';
?>

<div style="display: inline-block; position: absolute; right: 20px; margin-top: -58px">
    <a href="programmers.php"><p style="display: inline-block; color: #2667a0"><u>2023</u></p></a>
    <a href="programmers.php" style="display: inline-block; "><img src="images/copyright.png" style=" width: 15px; ; "></a>
    </div>

	</div>

    <script src="js/admin.js"></script>
    <script>

        function setDateTimeValue(inputId) {
            const dateTimeInput = document.getElementById(inputId);
            const now = new Date();
            const formattedDate = now.toISOString().slice(0, 16); // Format the current date and time
            dateTimeInput.value = formattedDate;
        }

const dateFields = ['Edate', 'PRdate', 'POdate'];

dateFields.forEach(field => {
    const date = document.getElementById(field);

    date.addEventListener('blur', function() {
        const enteredDate = date.value;
        const properFormat = convertToProperFormat(enteredDate);
        date.value = properFormat;
    });
});

function convertToProperFormat(dateString) {
    const parts = dateString.split(/[/ -]/);
    if (parts.length === 3) {
        const month = parts[0].padStart(2, '0');
        const day = parts[1].padStart(2, '0');
        const year = parts[2].padStart(4, '20');
        const formattedDate = `${month}/${day}/${year}`;
        const isValidDate = !isNaN(Date.parse(formattedDate));
        return isValidDate ? formattedDate : '';
    } else {
        return "";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const relativeTd = document.querySelector('.relative-td');
    const dropdownContent = relativeTd.querySelector('.dropdown-content');

    relativeTd.addEventListener('mouseenter', function () {
        const rect = relativeTd.getBoundingClientRect();
        dropdownContent.style.top = rect.height + 'px';
    });

    relativeTd.addEventListener('mouseleave', function () {
        dropdownContent.style.top = '100%'; // Reset to default
    });
});

document.addEventListener('DOMContentLoaded', function () {
        // Get the amount input element
        var amountInput = document.querySelector('input[name="amount"]');

        // Set the default value to 0
        amountInput.value = '0';

        // Listen for focus event on the amount field
        amountInput.addEventListener('focus', function () {
            // If the value is 0, set it to an empty string
            if (this.value === '0') {
                this.value = '';
            }
        });

        // Listen for blur event on the amount field
        amountInput.addEventListener('blur', function () {
            // If the value is empty, set it back to 0
            if (this.value === '') {
                this.value = '0';
            }
        });

        // Listen for input events on the amount field
        amountInput.addEventListener('input', function () {
            // If the value is 0, make it an empty string
            this.value = this.value === '0' ? '' : this.value;
        });
    });

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
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    function closeModal() {
        var modal = document.getElementById('modal');
        modal.style.display = 'none';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeLogoutPopup();
        }
    });

    function closeLogoutPopup() {
        var logoutPopup = document.getElementById('logout-popup');
        logoutPopup.style.display = 'none';
    }

    document.getElementById('logout-close').addEventListener('click', closeLogoutPopup);

    function checkOtherOption() {
        var selectBox = document.getElementById("personSelect");

        if (selectBox.value === "Other") {
            Swal.fire({
                title: 'Enter new person',
                input: 'text',
                inputPlaceholder: 'Enter new person\'s name',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Add',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Please enter a person\'s name';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const newPersonName = result.value;
                    addNewPerson(newPersonName);
                }
            });
        }
    }

    function addNewPerson(newPersonName) {
        var selectBox = document.getElementById("personSelect");

        var newOption = document.createElement("option");
        newOption.value = newPersonName;
        newOption.text = newPersonName;

        selectBox.appendChild(newOption);
        selectBox.value = newPersonName;
    }
    </script>

    </body>
</html>
