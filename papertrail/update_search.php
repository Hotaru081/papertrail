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
    $pno=$_GET['pno'];
    $query=mysqli_query($conn,"select * from details where pno='$pno'");
    $row=mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html>

<style>

body {
    background-color: #d3d3d3;
    overflow: none;
    margin: 0; /* Remove default body margin */
}

.edit {
    position: fixed;
    top: 15%;
    left: 30%;
    width: 35%;
    max-height: 70vh; /* Set a maximum height using viewport height units */
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
	padding-bottom: 20px;
}

label{
	font-size: 20px;
}

.edit_form {
    margin-bottom: 10px; /* Add some spacing between form elements */
    display: inline-block; /* Align form elements horizontally */
    width: calc(50% - 10px); /* Adjust width based on your layout */
    box-sizing: border-box;
}

.inp1 {
    width: 100%; /* Make input boxes full width within .edit_form */
    padding: 7px;
    border: 1px solid black;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box;
    margin: 0;
}

/* Media queries for responsiveness */
@media all and (max-width: 768px) {
    .edit {
        width: 80%;
        max-height: 72vh; /* Adjust maximum height for smaller screens */
        left: 10%;
        top: 10%;
    }
}

</style>

<head>
<title>PTCAO</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<link rel="icon" type="image/x-icon" href="images/batangas.png">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<button onclick="javascript:history.back()" class="back-button" style="top: 82%" >Back</button>
    
</head>
    <body>

        <div class="edit">
        <h2 style="text-align: center; font-size: 30px; margin-top: 0; color: #2667a0">Update</h2>
        <form method="POST" action="update_process.php?pno=<?php echo $pno; ?>" enctype="multipart/form-data">


            <div class="edit_form" style="width: 100%;">
                <label>PARTICULARS:</label><br>
                <input class="inp1" type="text" value="<?php echo $row['particulars']; ?>" name="particulars" style="width: 99.99%;">
            </div><br>

             <div class="edit_form" style="width: 49.5%">
            <label >PAPERTYPE:</label><br>
            <select class="inp1" name="papertype" style="width: 100%">
                <option value="Others" <?php if ($row['papertype'] == 'Others') echo 'selected'; ?>>Others</option>
                <option value="Emanating" <?php if ($row['papertype'] == 'Emanating') echo 'selected'; ?>>EMANATING</option>
                <option value="Purchase Request" <?php if ($row['papertype'] == 'Purchase Request') echo 'selected'; ?>>PURCHASE REQUEST</option>
                <option value="Earmark/Budget Certification" <?php if ($row['papertype'] == 'Earmark/Budget Certification') echo 'selected'; ?>>EARMARK/BUDGET CERTIFICATION</option>
                <option value="Purchase Order" <?php if ($row['papertype'] == 'Purchase Order') echo 'selected'; ?>>PURCHASE ORDER</option>
                <option value="QUOTATIONS" <?php if ($row['papertype'] == 'QUOTATIONS') echo 'selected'; ?>>QUOTATIONS</option>
                <option value="Request for Inspection" <?php if ($row['papertype'] == 'Request for Inspection') echo 'selected'; ?>>REQUEST FOR INSPECTION</option>
                <option value="Inspection and Acceptance" <?php if ($row['papertype'] == 'Inspection and Acceptance') echo 'selected'; ?>>INSPECTION AND ACCEPTANCE(AIP)</option>
                <option value="Waste Materials" <?php if ($row['papertype'] == 'Waste Materials') echo 'selected'; ?>>WASTE MATERIALS</option>
                <option value="PR VOUCHER" <?php if ($row['papertype'] == 'PR VOUCHER') echo 'selected'; ?>>PR VOUCHER</option>
                <option value="Project Proposal" <?php if ($row['papertype'] == 'Project Proposal') echo 'selected'; ?>>PROJECT PROPOSAL</option>
                <option value="Project Brief" <?php if ($row['papertype'] == 'Project Brief') echo 'selected'; ?>>PROJECT BRIEF</option>
                <option value="Work Program" <?php if ($row['papertype'] == 'Work Program') echo 'selected'; ?>>WORK PROGRAM</option>
                <option value="PPMP" <?php if ($row['papertype'] == 'PPMP') echo 'selected'; ?>>PPMP</option>
                <option value="PPMP - Addendum" <?php if ($row['papertype'] == 'PPMP - Addendum') echo 'selected'; ?>>PPMP - ADDENDUM</option>
                <option value="Certifications" <?php if ($row['papertype'] == 'Certifications') echo 'selected'; ?>>CERTIFICATIONS</option>

                <optgroup label="Voucher">
                    <option value="VOUCHER - Salary" <?php if ($row['papertype'] == 'VOUCHER - Salary') echo 'selected'; ?>>SALARY</option>
                    <option value="VOUCHER - RA" <?php if ($row['papertype'] == 'VOUCHER - RA') echo 'selected'; ?>>RA</option>
                    <option value="VOUCHER - RATA" <?php if ($row['papertype'] == 'VOUCHER - RATA') echo 'selected'; ?>>RATA</option>
                    <option value="VOUCHER - Benefits" <?php if ($row['papertype'] == 'VOUCHER - Benefits') echo 'selected'; ?>>BENEFITS</option>
                    <option value="VOUCHER - Subsidy" <?php if ($row['papertype'] == 'VOUCHER - Subsidy') echo 'selected'; ?>>SUBSIDY</option>
                    <option value="VOUCHER - Honorarium" <?php if ($row['papertype'] == 'VOUCHER - Honorarium') echo 'selected'; ?>>HONORARIUM</option>
                    <option value="VOUCHER - Prizes" <?php if ($row['papertype'] == 'VOUCHER - Prizes') echo 'selected'; ?>>PRIZES</option>
                </optgroup>

                <optgroup label="Payroll">
                    <option value="PAYROLL - Salary Permanent" <?php if ($row['papertype'] == 'PAYROLL - Salary Permanent') echo 'selected'; ?>>SALARY PERMANENT</option>
                    <option value="PAYROLL - Salary Casual" <?php if ($row['papertype'] == 'PAYROLL - Salary Casual') echo 'selected'; ?>>SALARY CASUAL</option>
                    <option value="PAYROLL - Salary JO" <?php if ($row['papertype'] == 'PAYROLL - Salary JO') echo 'selected'; ?>>SALARY JO</option>
                    <option value="PAYROLL - Benefits" <?php if ($row['papertype'] == 'PAYROLL - Benefits') echo 'selected'; ?>>BENEFITS</option>
                </optgroup>

                
                <option value="Comms. & Indorsement" <?php if ($row['papertype'] == 'Comms. & Indorsement') echo 'selected'; ?>>COMMS. & INDORSMENT</option>
                <option value="Attendance Sheet" <?php if ($row['papertype'] == 'Attendance Sheet') echo 'selected'; ?>>ATTENDANCE SHEET</option>
                <option value="PAAR" <?php if ($row['papertype'] == 'PAAR') echo 'selected'; ?>>PAAR</option>

                <optgroup label="HR Files">
                    <option value="HR Files - PDS" <?php if ($row['papertype'] == 'HR Files - PDS') echo 'selected'; ?>>PDS</option>
                    <option value="HR Files - IPCR" <?php if ($row['papertype'] == 'HR Files - IPCR') echo 'selected'; ?>>IPCR</option>
                    <option value="HR Files - SALN" <?php if ($row['papertype'] == 'HR Files - SALN') echo 'selected'; ?>>SALN</option>
                    <option value="HR Files - IDP" <?php if ($row['papertype'] == 'HR Files - IDP') echo 'selected'; ?>>IDP</option>
                    <option value="HR Files - Assumption" <?php if ($row['papertype'] == 'HR Files - Assumption') echo 'selected'; ?>>ASSUMPTION</option>
                </optgroup>

            </select>
            </div> 

            <div class="edit_form" style="width: 49.5%">
            <label>AMOUNT:</label><br>
            <input class="inp1"  style="width: 100%" type="number" value="<?php echo $row['amount']; ?>" name="amount" step="0.01" required>
            </div><br>

            <div class="edit_form" style="display: inline-block; width: 33.33%;">
                <label>EVENT DATE:</label><br>
                <input class="inp1" id="Edate" type="text" name="Edate" placeholder="MM/DD/YYYY" value="<?php echo $row['Edate']; ?>">
            </div>

            <div class="edit_form" style="display: inline-block; width: 33.33%;">
                <label>STATUS:</label><br>
            <select class="inp1" name="status" id="status" onchange="handleStatusChange()">
                <option value="Released" <?php if ($row['status'] == 'Released') echo 'selected'; ?>>RELEASED</option>
                <option value="Returned" <?php if ($row['status'] == 'Returned') echo 'selected'; ?>>RETURNED</option>
                <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>PENDING</option>
                <option value="Complete" <?php if ($row['status'] == 'Complete') echo 'selected'; ?>>COMPLETE</option>
                <option value="Signed" <?php if ($row['status'] == 'Signed') echo 'selected'; ?>>SIGNED</option>
                <option value="Problem" <?php if ($row['status'] == 'Problem') echo 'selected'; ?>>PROBLEM</option>
            </select>
            </div>

            <div class="edit_form" style="display: inline-block; width: calc(33.33% - 10px);">
                <label>OFFICE:</label><br>
               <select class="inp1" name="office" id="office" required>
                <option value="PTCAO" <?php if ($row['office'] == 'PTCAO') echo 'selected'; ?>>PTCAO</option>
                <option value="OPG" <?php if ($row['office'] == 'OPG') echo 'selected'; ?>>OPG</option>
                <option value="ADMIN" <?php if ($row['office'] == 'ADMIN') echo 'selected'; ?>>ADMIN</option>
                <option value="BUDGET" <?php if ($row['office'] == 'BUDGET') echo 'selected'; ?>>BUDGET</option>
                <option value="ACCOUNTING" <?php if ($row['office'] == 'ACCOUNTING') echo 'selected'; ?>>ACCOUNTING</option>
                <option value="PTO" <?php if ($row['office'] == 'PTO') echo 'selected'; ?>>PTO</option>
                <option value="PHRMO" <?php if ($row['office'] == 'PHRMO') echo 'selected'; ?>>PHRMO</option>
                <option value="GSO" <?php if ($row['office'] == 'GSO') echo 'selected'; ?>>GSO</option>
                <option value="BAC" <?php if ($row['office'] == 'BAC') echo 'selected'; ?>>BAC</option>
                <option value="PPDO" <?php if ($row['office'] == 'PPDO') echo 'selected'; ?>>PPDO</option>
                <option value="PDRRMO" <?php if ($row['office'] == 'PDRRMO') echo 'selected'; ?>>PDRRMO</option>
                <option value="PSWDO" <?php if ($row['office'] == 'PSWDO') echo 'selected'; ?>>PSWDO</option>
            </select>
            </div><br>

            <div class="edit_form" style="width: 100%;">
                <label>COMMENTS:</label><br>
                <input class="inp1" type="text" value="<?php echo $row['comments']; ?>" name="comments" style="width: 100%; border-bottom: 2px solid #333; margin-bottom: 20px">
            </div><br>

            <div class="edit_form" style="display: inline-block; width: 33.33%;">
                <label>EMANATE NO.:</label><br>
                <input class="inp1" type="text" value="<?php echo $row['Eno']; ?>" name="Eno">
            </div>

            <div class="edit_form" style="display: inline-block; width: 33.33%;">
                <label>PR NO.:</label><br>
                <input class="inp1" type="text" value="<?php echo $row['PRno']; ?>" name="PRno">
            </div>

            <div class="edit_form" style="display: inline-block; width: calc(33.33% - 10px);">
                <label>PR DATE:</label><br>
                <input class="inp1" id="PRdate" type="text" name="PRdate" placeholder="MM/DD/YYYY" value="<?php echo $row['PRdate']; ?>">
            </div><br>

            <div class="edit_form" style="display: inline-block; width: 49.5%;">
                <label>PO NO.:</label><br>
                <input class="inp1" type="text" value="<?php echo $row['POno']; ?>" name="POno">
            </div>

            <div class="edit_form" style="display: inline-block; width: 49.5%;">
                <label>PO DATE:</label><br>
                <input class="inp1" id="POdate" type="text" name="POdate" placeholder="MM/DD/YYYY" value="<?php echo $row['POdate']; ?>">
            </div>

            <div class="edit_form" style="display: inline-block; width: 33.33%;">
                <label>LAST TOUCHED:</label><br>
                <select class="inp1" name="person" id="personSelect" onchange="checkOtherOption()">
                    <option value="">----</option>
                    <option value="Roger"  <?php if ($row['person'] == 'Roger') echo 'selected'; ?>>Roger</option>
                    <option value="Krystel"  <?php if ($row['person'] == 'Krystel') echo 'selected'; ?>>Krystel</option>
                    <option value="Chona"  <?php if ($row['person'] == 'Chona') echo 'selected'; ?>>Chona</option>
                    <option value="Kiko"  <?php if ($row['person'] == 'Kiko') echo 'selected'; ?>>Kiko</option>
                    <option value="JMC"  <?php if ($row['person'] == 'JMC') echo 'selected'; ?>>JMC</option>
                    <option value="Contractor"  <?php if ($row['person'] == 'Contractor') echo 'selected'; ?>>Contractor</option>
                    <option value="Other"  <?php if ($row['person'] == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>

            <div class="edit_form" style="display: inline-block; width: 33.33%;">
                <label>ADMIN:</label><br>
                <input class="inp1" type="text" value="<?php echo $_SESSION['username']; ?>" name="admin">
            </div>
            
            <div class="edit_form" style="display: inline-block; width: calc(33.33% - 10px);">
                <label>FILES:</label><br>
                <input class="inp1" type="file" name="files[]" id="file" multiple accept=".pdf, .jpg, .jpeg, .png" style="padding-top: 4px; padding-bottom: 4px">
            </div>

            <div class="edit_form" style="display: inline-block; width: 15.33%;">
                <label>YEAR:</label><br>
                <input class="inp1" type="text" value="<?php echo $row['taon']; ?>" name="taon">
            </div>

            <div class="edit_form" style="display: inline-block; width: 15.33%;">
                <label>RC:</label><br>
            <select class="inp1" name="resp_center" id="resp_center">
                <option value="99201" <?php if ($row['resp_center'] == '99201') echo 'selected'; ?>>99201</option>
                <option value="92202" <?php if ($row['resp_center'] == '92202') echo 'selected'; ?>>92202</option>
                <option value="1123" <?php if ($row['resp_center'] == '1123') echo 'selected'; ?>>1123</option>
            </select>
            </div>

            <div class="edit_form" style="width: 32%;">
            <label >ACCOUNT TYPE:</label><br>
            <select class="inp1" name="account_type" style="width: 212%">

                <optgroup label="1123">
                    <option value="OFFICE SUPPLIES - 50203010" <?php if ($row['account_type'] == 'OFFICE SUPPLIES - 50203010') echo 'selected'; ?>>OFFICE SUPPLIES - 50203010</option>
                    <option value="OTHER SUPPLIES & MATERIALS EXPENSE - 50203990" <?php if ($row['account_type'] == 'OTHER SUPPLIES & MATERIALS EXPENSE - 50203990') echo 'selected'; ?>>OTHER SUPPLIES & MATERIALS EXPENSE - 50203990</option>
                    <option value="FUEL, OIL AND LUBRICANT - 50203090" <?php if ($row['account_type'] == 'FUEL, OIL AND LUBRICANT - 50203090') echo 'selected'; ?>>FUEL, OIL AND LUBRICANT - 50203090</option>
                    <option value="TELEPHONE EXPENSE - 50205020" <?php if ($row['account_type'] == 'TELEPHONE EXPENSE - 50205020') echo 'selected'; ?>>TELEPHONE EXPENSE - 50205020</option>
                    <option value="INTERNET & SUBSCRIPTION EXPENSE - 50205030" <?php if ($row['account_type'] == 'INTERNET & SUBSCRIPTION EXPENSE - 50205030') echo 'selected'; ?>>INTERNET & SUBSCRIPTION EXPENSE - 50205030</option>
                    <option value="OTHER MAINTENANCE & OTHER OPERATION EXPENSE - 50299990" <?php if ($row['account_type'] == 'OTHER MAINTENANCE & OTHER OPERATION EXPENSE - 50299990') echo 'selected'; ?>>OTHER MAINTENANCE & OTHER OPERATION EXPENSE - 50299990</option>
                </optgroup>

                <optgroup label="REPAIR & MAINTENANCE">
                    <option value="RM - BUILDING & OTHER STRUCTURE - 10704010" <?php if ($row['account_type'] == 'RM - BUILDING & OTHER STRUCTURE - 10704010') echo 'selected'; ?>>RM - BUILDING & OTHER STRUCTURE - 10704010</option>
                    <option value="RM - MACHINERY & EQUIPMENT - 50213050" <?php if ($row['account_type'] == 'RM - MACHINERY & EQUIPMENT - 50213050') echo 'selected'; ?>>RM - MACHINERY & EQUIPMENT - 50213050</option>
                    <option value="RM - TRANSPORTATION - 50212060" <?php if ($row['account_type'] == 'RM - TRANSPORTATION - 50212060') echo 'selected'; ?>>RM - TRANSPORTATION - 50212060</option>
                    <option value="RM - FURNITURE & FIXTURES - 50213070" <?php if ($row['account_type'] == 'RM - FURNITURE & FIXTURES - 50213070') echo 'selected'; ?>>RM - FURNITURE & FIXTURES - 50213070</option>
                    <option value="SUBSCRIPTION EXPENSE - 50299070" <?php if ($row['account_type'] == 'SUBSCRIPTION EXPENSE - 50299070') echo 'selected'; ?>>SUBSCRIPTION EXPENSE - 50299070</option>
                    <option value="POSTAGE & COURIER SERVICE - 50205010" <?php if ($row['account_type'] == 'POSTAGE & COURIER SERVICE - 50205010') echo 'selected'; ?>>POSTAGE & COURIER SERVICE - 50205010</option>
                    <option value="TAXES, DUTIES & LICENSES - 50216010" <?php if ($row['account_type'] == 'TAXES, DUTIES & LICENSES - 50216010') echo 'selected'; ?>>TAXES, DUTIES & LICENSES - 50216010</option>
                    <option value="INSURANCE EXPENSES - 50216030" <?php if ($row['account_type'] == 'INSURANCE EXPENSES - 50216030') echo 'selected'; ?>>INSURANCE EXPENSES - 50216030</option>
                </optgroup>

                    <optgroup label="99201/92202">
                    <option value="TRAVELLING EXPENSES - 50201010" <?php if ($row['account_type'] == 'TRAVELLING EXPENSES - 50201010') echo 'selected'; ?>>TRAVELLING EXPENSES - 50201010</option>
                    <option value="TRAINING EXPENSES - 50202010" <?php if ($row['account_type'] == 'TRAINING EXPENSES - 50202010') echo 'selected'; ?>>TRAINING EXPENSES - 50202010</option>
                    <option value="REPRESENTATION EXPENSES - 50299030" <?php if ($row['account_type'] == 'REPRESENTATION EXPENSES - 50299030') echo 'selected'; ?>>REPRESENTATION EXPENSES - 50299030</option>
                    <option value="PRIZES - 50206020" <?php if ($row['account_type'] == 'PRIZES - 50206020') echo 'selected'; ?>>PRIZES - 50206020</option>
                    <option value="OTHER PROFESSIONAL SERVICES - 50211990" <?php if ($row['account_type'] == 'OTHER PROFESSIONAL SERVICES - 50211990') echo 'selected'; ?>>OTHER PROFESSIONAL SERVICES - 50211990</option>
                    <option value="SUBSIDY TO LGO - 50214030" <?php if ($row['account_type'] == 'SUBSIDY TO LGO - 50214030') echo 'selected'; ?>>SUBSIDY TO LGO - 50214030</option>
                    <option value="ADVERTISING EXPENSES - 50299010" <?php if ($row['account_type'] == 'ADVERTISING EXPENSES - 50299010') echo 'selected'; ?>>ADVERTISING EXPENSES - 50299010</option>
                    <option value="PRINTING & PUBLIC EXPENSES - 50299020" <?php if ($row['account_type'] == 'PRINTING & PUBLIC EXPENSES - 50299020') echo 'selected'; ?>>PRINTING & PUBLIC EXPENSES - 50299020</option>
                    <option value="RENT EXPENSES - 50299050" <?php if ($row['account_type'] == 'RENT EXPENSES - 50299050') echo 'selected'; ?>>RENT EXPENSES - 50299050</option>
                    <option value="CONSULTANCY EXPENSES - 50211030" <?php if ($row['account_type'] == 'CONSULTANCY EXPENSES - 50211030') echo 'selected'; ?>>CONSULTANCY EXPENSES - 50211030</option>
                </optgroup>

                    <optgroup label="CAPITAL OUTLAY">
                    <option value="CA - ICT EQUIPMENT - 10705030" <?php if ($row['account_type'] == 'CA - ICT EQUIPMENT - 10705030') echo 'selected'; ?>>CA - ICT EQUIPMENT - 10705030</option>
                    <option value="CA - COMMUNICATION EQUIPMENT - 10705070" <?php if ($row['account_type'] == 'CA - COMMUNICATION EQUIPMENT - 10705070') echo 'selected'; ?>>CA - COMMUNICATION EQUIPMENT - 10705070</option>
                    <option value="CA - OFFICE EQUIPMENT - 10705020" <?php if ($row['account_type'] == 'CA - OFFICE EQUIPMENT - 10705020') echo 'selected'; ?>>CA - OFFICE EQUIPMENT - 10705020</option>
                    <option value="CA - FURNITURE & FIXTURES - 10707010" <?php if ($row['account_type'] == 'CA - FURNITURE & FIXTURES - 10707010') echo 'selected'; ?>>CA - FURNITURE & FIXTURES - 10707010</option>
                    <option value="CA - MILITARY, POLICE & SECURITY EQUIPMENT - 10705100" <?php if ($row['account_type'] == 'CA - MILITARY, POLICE & SECURITY EQUIPMENT - 10705100') echo 'selected'; ?>>CA - MILITARY, POLICE & SECURITY EQUIPMENT - 10705100</option>
                    <option value="OTHER MACHINERY & EQUIPMENT - 10705990" <?php if ($row['account_type'] == 'OTHER MACHINERY & EQUIPMENT - 10705990') echo 'selected'; ?>>OTHER MACHINERY & EQUIPMENT - 10705990</option>
                </optgroup>
            </select>
            </div>

            <div>
            <input style="width: 100%; padding: 8px; background-color: #2667a0; color: white; border-radius: 4px; margin-bottom: 5px; margin-top: px; cursor: pointer; font-size: 20px" type="submit" name="submit">
            </div>

            <div class="edit_form" style="visibility: hidden;">
            <label>PAPER NO.:</label><br>
            <input class="inp1" type="text" style="width: 200px; box-sizing: border-box;" value="<?php echo $row['pno']; ?>" name="pno" readonly>
            </div>
			

        </form>
    </div>
	<script>

function handleStatusChange() {
    var statusField = document.getElementById('status');
    var officeField = document.getElementById('office');

    // Check if the selected status is 'Returned'
    if (statusField.value === 'Returned' , 'Pending') {
        // Set the office to 'PTCAO' if status is 'Returned'
        officeField.value = 'PTCAO';
	} else if (statusField.value === 'Released' && officeField.value === 'PTCAO') {
        // Set the office to a different value when status is 'Released'
        officeField.value = ''; // Clear the office field when status is 'Released'
    }
}
const date = document.getElementById('date');

date.addEventListener('blur', function() {
    const enteredDate = date.value;
    const properFormat = convertToProperFormat(enteredDate);
    date.value = properFormat;
});

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
        return `${month}/${day}/${year}`;
    } else {
        return "Invalid date";
    }
}
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

    // Create a new option element
    var newOption = document.createElement("option");
    newOption.value = newPersonName;
    newOption.text = newPersonName;

    // Add the new option to the select box
    selectBox.appendChild(newOption);

    // Set the newly added option as selected
    selectBox.value = newPersonName;
}
</script>
</body>
</html>