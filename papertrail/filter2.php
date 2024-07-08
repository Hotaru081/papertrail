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
        font-family: Arial, sans-serif;
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

    .roww{
            display: inline-block;
            position: absolute;
            margin-top: -37px;
            margin-left: 57.46%;
            
        }

        .form-select{
            padding: 3px;
        }

        .filterr{
    margin-right: 20px;
    border: 0;
    background-color: #2667a0; 
    color: white; 
    padding: 5px; 
    border-radius: 4px; 
    padding-right: 10px; 
    padding-left: 10px;
    border: 1px solid black;
}

.resett{
    margin-right: 20px;
    border: 0;
    background-color: #2667a0; 
    color: white; 
    padding-top: 3px; 
    padding-bottom: 5px; 
    padding-right: 10px; 
    padding-left: 10px; 
    text-decoration: none; 
    margin-left: -20px; 
    border-radius: 4px;
    border: 1px solid black;
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

    .dropdown-button {
        text-align: center;
        justify-content: center;
        display: inline-block;
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
        padding: 8px 1px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #2667a0;
        color: white;
    }
            /* Show the dropdown content when the dropdown button is hovered */
    .dropdown-button:hover + .dropdown-content {
        display: block;
        }

    .dropdown-content a {
        width: 100%;
    }     

    .dropdown-item {
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        color: #333;

        }

    .arrow-down {
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 6px solid #000;
        display: inline-block;
        margin-left: 5px;
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


    </style>

    <head>
        <title>PTCAO</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <link rel="icon" type="image/x-icon" href="images/batangas.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </head>
    <body>

    <nav class="navbar" style="display: flex; align-items: center; justify-content: space-between;">
    <div class="navbar-left" style="display: flex; align-items: center;">
        <img src="images/batangas.png" alt="" style="width: 25px; margin-left: 10px; margin-right: 10px; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3); border-radius: 50%">
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="font-size: 1.5rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Filtered Data:</li>
        </ul>
    </div>

    <div class="navbar-right" style="visibility: hidden">

            <img src="images/nobg.png" alt="" style="width: 20px; margin-left: 25px">
        
    </div>
</nav>


        <form action="filter.php" method="POST">
        <div class="roww">
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

                <button type="submit" class="filterr" >Filter</button>
                <a href="home2.php" class="resett" >Reset</a>

            </div>
    </form>



    <!-- SEARCH -->
        <form action="search_filter2.php" method="GET" class="sch">
            <input class="inp_sch" type="text" name="query" placeholder="Enter your search term">
            <input class="btn_sch" type="submit" value="Search">
        </form>

    <!-- LOGIN -->
    <div id="login-popup" class="popup">
            <div class="popup-content">
                <span class="close" id="login-close">&times;</span>
                <h2 style="text-align: center">Login</h2>
                <div class="warn">
                    <h3 style="text-align: center; color: #EE4B2B;">Note:</h3>
                    <h4 style="text-align: center; margin-top: -20px; color: #EE4B2B;">Only the Admins are authorized to login</h4>
                </div>
                <form action="login_process.php" method="post">
                    <label for="username" style="font-size: 18px">Username:</label><br>
                    <input class="inp" type="text" name="username" placeholder="Enter username" required
                        <?php echo isset($_COOKIE['remember_me_username']) ? 'value="' . $_COOKIE['remember_me_username'] . '"' : ''; ?>><br>
                    <label for="password" style="font-size: 18px">Password:</label><br>
                    <div class="password-input">
                        <input class="inp" type="password" name="password" id="passwordField" placeholder="Enter password" required <?php echo isset($_COOKIE['remember_me_password']) ? 'value="' . $_COOKIE['remember_me_password'] . '"' : ''; ?>>
                        <span class="toggle-password" onclick="togglePasswordVisibility()">
                            <i id="toggleIcon" class="fa fa-eye-slash" style="margin-right: -20px"></i>
                        </span>
                    </div>
                    <label for="remember_me" style="font-size: 16px">
                        <input type="checkbox" name="remember_me" <?php echo isset($_COOKIE['remember_me_username']) ? 'checked' : ''; ?>>
                        Remember Me
                    </label><br><br>
                    <input class="sub" type="submit" value="Login" style="cursor: pointer">
                </form>

            </div>
        </div>

    <!-- Display filtered rows -->  
    <div class="tabs scroll-content" style="margin-top: 118px; height: 720px ">
		<table style="border: 1px;" class="table">
			<thead class="tabs_name" style="font-size: 13px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                <th style="width: 7%;">ACTIONS</th>
                <th style="width: 20%">PARTICULARS</th>
				<th>PAPER TYPE</th>
                <th>AMOUNT</th>
                <th style="width: 7%">EVENT DATE</th>
                <th style="width: 6%">STATUS</th>
                <th style="width: 8%">OFFICE</th>
                <th style="width: 8%">PERSON</th>
                <th style="width: 8%">ADMIN</th>
                <th style="width: 8%">DATE UPDATE</th>
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
                        <a href="attachment_home.php?pno=<?php echo $row['pno']; ?>" style="font-size: 13px; margin-left: 18px; text-decoration: none; color: black; font-weight: bold;">Attachment<i class="fas fa-paperclip fa-sm" style="margin-left: 5px; color: #2667a0"></i></a>
                        <a href="checklist_home.php?id=<?php echo $row['id']; ?>" style="font-size: 13px; margin-left: 18px; text-decoration: none; color: black; font-weight: bold">Checklist<i class="fas fa-check-square fa-sm" style="margin-left: 18px; color: green"></i></a>
                            </div>
                        </td>

                        <td style="padding-left: 10px">
                            <a href="activity_log.php?pno=<?php echo $row['pno']; ?>" style="color: #126dbc; text-decoration: none; padding-right: 10px">
                                <?php echo $row['particulars']; ?>
                            </a>
                        </td>
                        <td style="text-align:center"><?php echo $row['papertype']; ?></td>
                        <td style="text-align:right"><?php $amount = $row['amount'];if ($amount != 0) {echo number_format($amount, 2);}?></td>
                        <td style="text-align:center"><?php echo $row['Edate']; ?></td>
                        <td style="text-align:center"><?php echo $row['status']; ?></td>
                        <td style="text-align:center; font-size: 13px;"><?php echo $row['office']; ?></td>
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

    <div style="display: inline-block; position: absolute; right: 20px; ">
    <a href="programmers.php"><p style="display: inline-block; color: #2667a0"><u>2023</u></p></a>
    <a href="programmers.php" style="display: inline-block; "><img src="images/copyright.png" style=" width: 15px; ; "></a>
    </div>

	</div>

        <div id="imageModal" class="modal">
        <span class="close" onclick="closeImageModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <div id="modal-overlay"></div>

    <script>

    function openModal() {
    var modal = document.getElementById("staticBackdrop");
    modal.style.display = "block";
    }

    function closeModal() {
    var modal = document.getElementById("staticBackdrop");
    modal.style.display = "none";
    }

    const loginButton = document.getElementById("login-button");
    const loginPopup = document.getElementById("login-popup");
    const loginClose = document.getElementById("login-close");
    loginButton.addEventListener("click", function () {
        loginPopup.style.display = "block";
    });
    loginClose.addEventListener("click", function () {
        loginPopup.style.display = "none";
    });
    window.addEventListener("click", function (event) {
        if (event.target === loginPopup) {
            loginPopup.style.display = "none";
        }
    });

    function togglePasswordVisibility() {
                var passwordField = document.getElementById("passwordField");
                var toggleIcon = document.getElementById("toggleIcon");

                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    toggleIcon.className = "fa fa-eye";
                } else {
                    passwordField.type = "password";
                    toggleIcon.className = "fa fa-eye-slash";
                }
            }

        
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
