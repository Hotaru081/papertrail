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
    color: #283a49; /* Text color on hover */
}

.row{
        display: inline-block;
        position: absolute;
        margin-top: 103px;
        margin-left: 10px;
        
    }

    .form-select{
        padding: 3px;
        border-radius: 4px;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <nav class="navbar" style="display: flex; align-items: center; justify-content: space-between; ">
    <div class="navbar-left" style="display: flex; align-items: center; margin-left: 10px">
        <img src="images/batangas.png" alt="" style="width: 25px; margin-right: 10px; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3); border-radius: 50%">
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="font-size: 1.5rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5)" ><a href="admin.php" class="hover-link">PTCAO PAPERTRAIL</a></li>
        </ul>
    </div>

    <div class="navbar-admin" style="box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3);">
                <p>Welcome, <b><u><?php echo $username; ?>!</u></b></p>
                <button id="logout-popup-button" class="btn">
                <img src="images/nobg.png" alt="" style="width: 25px;">
                </button>
        </div>
</nav>

<form action="filter2.php" method="POST">
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
                <option value="Returned" <?= isset($_POST['status']) && $_POST['status'] == 'Returned' ? 'selected' : '' ?>>RETURNED</option>
                <option value="Released" <?= isset($_POST['status']) && $_POST['status'] == 'Released' ? 'selected' : '' ?>>RELEASED</option>
                <option value="Pending" <?= isset($_POST['status']) && $_POST['status'] == 'Pending' ? 'selected' : '' ?>>PENDING</option>
                <option value="Complete" <?= isset($_POST['status']) && $_POST['status'] == 'Complete' ? 'selected' : '' ?>>COMPLETE</option>
                <option value="Signed" <?= isset($_POST['status']) && $_POST['status'] == 'Signed' ? 'selected' : '' ?>>SIGNED</option>
                <option value="Problem" <?= isset($_POST['status']) && $_POST['status'] == 'Problem' ? 'selected' : '' ?>>PROBLEM</option>
            </select>

            <button type="submit" class="filter ">Filter</button>
            <a href="home2.php" class="reset ">Reset</a>


        </div>

    </div>
</form>



<!-- SEARCH -->
    <form action="search_home2.php" method="GET" class="sch">
        <input class="inp_sch" type="text" name="query" placeholder="Enter your search term">
        <input class="btn_sch" type="submit" value="Search">
    </form>

<!-- LOGOUT -->
<div id="logout-popup" class="popup">
        <div class="popup-content" style="width: 250px; height: 190px; text-align: center; justify-content: center;">
            <span class="close" id="logout-close">&times;</span>
            <h2>Logout</h2>
            <h3 style="margin-top: -15px">Confirmation</h3>
            <p style="color: #EE4B2B; font-weight: bold">Are you sure you want to logout?</p>
            <form action="logout_process.php" method="post">
                <input type="submit" value="Logout" style="width: 100%; padding: 10px; margin-top: 10px; background-color: #2667a0; color: white; border-radius: 5px;">
            </form>
        </div>
    </div>

	<br>
	<div class="tabs scroll-content">
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

                $limit = 13; // Number of records per page
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
                
                    if ($row['status'] === 'Problem') {
                        // If status is 'problem', set the row to have a red background
                        echo '<tr class="problem-row">';
                    } elseif ($row['status'] === 'Complete') {
                        // If status is 'completed', set the row to have a green background
                        echo '<tr class="completed-row">';
                    } elseif ($row['timestamp'] < $oneMonthAgo) {
                        // Rows updated more than a month ago
                        echo '<tr class="month-row">';
                    } elseif ($row['timestamp'] < $sevenDaysAgo) {
                        // Rows updated 7 days ago
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
echo "<li><a href='home2.php?page=" . $prevPage . "'>&lt;</a></li>";

for ($i = $startPage; $i <= $endPage; $i++) {
    if ($i == $page || ($i == 1 && $page == 0)) {
        $bgColor = ($i == 1) ? 'background-color: #ffcccb;' : '';
        echo "<li class='current'><a href='home2.php?page=" . $i . "'>$i</a></li>";
    } else {
        echo "<li><a href='home2.php?page=" . $i . "'>$i</a></li>";
    }
}

// Add the right arrow after the last visible page
$nextPage = ($page < $total_pages) ? $page + 1 : 1; // Wrap to page 1 if on the last page
echo "<li><a href='home2.php?page=" . $nextPage . "'>&gt;</a></li>";

echo '</ul>';
?>

<div style="display: inline-block; position: absolute; right: 20px; margin-top: -58px">
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

const logoutPopupButton = document.getElementById("logout-popup-button");
const logoutPopup = document.getElementById("logout-popup");
const logoutClose = document.getElementById("logout-close");

logoutPopupButton.addEventListener("click", function () {
    logoutPopup.style.display = "block";
});

logoutClose.addEventListener("click", function () {
    logoutPopup.style.display = "none";
});

window.addEventListener("click", function (event) {
    if (event.target === logoutPopup) {
        logoutPopup.style.display = "none";
    }
});

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


    document.addEventListener("DOMContentLoaded", function () {
    var paginationLinks = document.querySelectorAll(".pagination a");

    paginationLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            // Remove the 'current-page' class from all links
            paginationLinks.forEach(function (link) {
                link.classList.remove("current-page");
            });

            // Add the 'current-page' class to the clicked link
            event.target.classList.add("current-page");
        });
    });
});
document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeLogoutPopup();
        }
    });

    function closeLogoutPopup() {
        var logoutPopup = document.getElementById('logout-popup');
        logoutPopup.style.display = 'none';
    }

    // Add the following line to your existing script to close the modal when clicking on the close button:
    document.getElementById('logout-close').addEventListener('click', closeLogoutPopup);

</script>
</body>
</html>