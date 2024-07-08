<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: admin.php"); // Redirect to the login page or another appropriate page
    exit();
}

// Check if the user is neither 'admin' (role: 0) nor 'superadmin' (role: 1)
if ($_SESSION['role'] === '0' && $_SESSION['role'] === '1') {
    die("Unauthorized access"); // Display an error message and terminate the script if the role is not 'admin' or 'superadmin'
}

$username = $_SESSION['username'];
?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>PTCAO</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="css/styles.css">
            <link rel="icon" type="image/x-icon" href="images/batangas.png">            
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <!-- Include Bootstrap CSS -->

            <style>
                h2 {
                    justify-content: center;
                    text-align: center;
                }

                .table-container {
                    margin-top: 10px;
                    margin-left: 10px;
                    margin-right: 10px;
                    height: 70vh;
                    max-height: 00px;
                }

                .back-buttonn {
                    margin-top: 80px;
                    background-color: #2667a0;
                    color: white;
                    padding: 5px;
                    padding-left: 20px;
                    padding-right: 20px;
                    border-radius: 5px;
                    margin-left: 10px;
                }

                .scroll-content {
                    overflow: auto;
                    height: 75vh;
                    max-height: 820px;
                    border-bottom: 5px solid #2667a0;
                    border-right: 2px solid #d3d3d3;
                    border-left: 2px solid #d3d3d3;  
                    background-color: white;
                }

                .head {
                    position: sticky;
                    top: 0;
                    font-weight: none;
                }

                .part {
                    width: 40%;
                }

                .time {
                    width: 10%;
                }

                .attach {
                    height: 50px;
                }

                .paper {
                    text-align: center;
                    justify-content: center;
                }

                .update,
                .delete-btn {
                    background-color: transparent;
                    border: none;
                    cursor: pointer;
                    margin-right: 10px;
                }

                .delete-btn {
                    color: #ff5252;
                }

                /* Add styles for the custom modal */
                .custom-modal {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    justify-content: center;
                    align-items: center;
                }

                .modal-content {
                    background-color: white;
                    padding: 20px;
                    border-radius: 5px;
                    max-width: 500px;
                    margin: auto;
                    text-align: center;
                }

                .close-btn {
                    cursor: pointer;
                    position: absolute;
                    top: 10px;
                    right: 10px;
                }
            </style>
        </head>
        <body>
            <nav class="navbar" style="display: flex; align-items: center; justify-content: space-between; ">
                <div class="navbar-left" style="display: flex; align-items: center;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="font-size: 1.5rem; font-weight: bold;">Attachments</li>
                    </ul>
                </div>
                <div class="navbar-right" style="visibility: hidden;">
                    <button id="login-button" class="btn" >
                        <p style="margin-right: 10px;"><u>Login</u></p>
                        <img src="images/nobg.png" alt="" style="width: 20px;">
                    </button>
                </div>
            </nav>
            
            <button onclick="goBack()" class="back-buttonn">Back</button>

            <?php
            include('connection.php');

            // Check if the 'pno' query parameter is set
            if (isset($_GET['pno'])) {
                // Get the 'pno' value from the query parameter
                $pno = $_GET['pno'];

                // Perform a search in your database based on the 'pno' value
                $query = mysqli_query($conn, "SELECT DISTINCT timestamp FROM attachments WHERE pno = '$pno' ORDER BY timestamp DESC");

                echo "<div class='table-container'>
                        <div class='scroll-content'>
                            <table>
                                <tr class='head' style='font-size: 15px;'>
                                    <th style='width:20%' class='part'>PARTICULARS</th>
                                    <th style='width:10%' class='part'>PAPERTYPE</th>
                                    <th>IMAGES</th>
                                    <th style='width:10%' class='time'>TIME</th>
                                    <th style='width:8%' class='part'>ACTIONS</th>
                                </tr>";
                echo '<tbody>';

                while ($timestamp_row = mysqli_fetch_array($query)) {
                    $timestamp = $timestamp_row['timestamp'];
                    echo "<tr >
                            <td>";

                    // Fetch particulars and papertype associated with the timestamp
                    $details_query = mysqli_query($conn, "SELECT particulars, papertype FROM attachments WHERE pno = '$pno' AND timestamp = '$timestamp'");
                    $details_row = mysqli_fetch_array($details_query);
                    echo $details_row['particulars'];

                    echo "</td>
                            <td class='paper'>" . $details_row['papertype'] . "</td>
                            <td class='paper'>";

                    // Fetch all files associated with the timestamp
                    $files_query = mysqli_query($conn, "SELECT image FROM attachments WHERE pno = '$pno' AND timestamp = '$timestamp'");

                    while ($file_row = mysqli_fetch_array($files_query)) {
                        $file_path = 'Uploads/' . $file_row["image"];
                        $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

                        if (strtolower($file_extension) === 'pdf') {
                            // Display PDF icon
                            echo "<a href='" . $file_path . "' target='_blank'>
                                        <img class='attach' src='images/PDF_ICON.png' alt='PDF Icon'>
                                    </a>";
                        } else {
                            // Display image
                            echo "<a href='" . $file_path . "' target='_blank'>
                                        <img class='attach' src='" . $file_path . "' alt='File'>
                                    </a>";
                        }
                    }

                    echo "
                            </td>
                            <td class='paper'>" . date('m/d/Y h:i A', strtotime($timestamp)) . "</td>
                            <td class='paper'>
                                <!-- Button to trigger the modal -->
                                <button class='update btn' onclick='openCustomModal(\"updateModal_$timestamp\")'>
                                    Update<i class='fas fa-edit fa-sm' style='margin-left: 7px'></i>
                                </button>
                                <button class='delete-btn' onclick='deleteRow(\"$pno\", \"$timestamp\")'>
                                    Delete<i class='fas fa-trash fa-sm' style='margin-left: 7px'></i>
                                </button>
                            </td>
                        </tr>";
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>';

                // Include the modal for each timestamp
                $query = mysqli_query($conn, "SELECT DISTINCT timestamp FROM attachments WHERE pno = '$pno' ORDER BY timestamp DESC");
                while ($timestamp_row = mysqli_fetch_array($query)) {
                    $timestamp = $timestamp_row['timestamp'];
                    include('update_modal.php');
                }

            } else {
                echo 'No search query provided.';
            }
            ?>

            <div style="display: inline-block; position: absolute; right: 20px; ">
            <a href="programmers.php"><p style="display: inline-block; color: #2667a0"><u>2023</u></p></a>
            <a href="programmers.php" style="display: inline-block; "><img src="images/copyright.png" style=" width: 15px; ; "></a>
            </div>

            <!-- Include Bootstrap JS and Popper.js -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

            <script>
                function openCustomModal(modalId) {
                    var modal = document.getElementById(modalId);
                    modal.style.display = 'flex';
                }

                function closeCustomModal(modalId) {
                    var modal = document.getElementById(modalId);
                    modal.style.display = 'none';
                }

                function deleteRow(pno, timestamp) {
            // Display a confirmation dialog
            var confirmDelete = confirm("Are you sure you want to delete this row?");
            
            if (confirmDelete) {
                // User clicked OK, proceed with deletion
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_data.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        if (xhr.responseText.trim() === "success") {
                            // Row deleted successfully, remove it from the table
                            var row = document.getElementById("row_" + timestamp);
                            row.parentNode.removeChild(row);
                        } else {
                            // Handle error
                            alert("Error deleting row. Please try again.");
                        }
                    }
                };

                var params = "pno=" + pno + "&timestamp=" + timestamp;
                xhr.send(params);
            }
        }

        function goBack() {
      history.back();
    }

    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        event.preventDefault(); // Prevent other potential actions associated with the Escape key
        goBack();
      }
    });

            </script>
        </body>
        </html>
