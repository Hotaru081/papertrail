<!DOCTYPE html>
<html>

<style>

    h2{
        justify-content: center;
        text-align: center;
    }

    .table-container{
        margin-top: 5px;
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
        margin-bottom: 5px;
    }
    .scroll-content{
        background-color: white;
        overflow: auto;
        height: 80vh;
        max-height: 820px;
        border-right: 2px solid #d3d3d3;
        border-left: 2px solid #d3d3d3;
        border-bottom: 5px solid #2667a0;
    }
    .head{
        position: sticky;
        top: 0;
    }

    .part{
        width: 20%;
    }

    .paper{
        text-align: center;
        justify-content: center;
    }

    th{
        font-size: 12px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .del{
        border: none;
        outline: none;
        background-color: transparent;
        margin-left: 10px;
    }

    .fas{
        color: red;
        margin-left: 3px;
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
    <div class="navbar-left" style="display: flex; align-items: center;">
        
    <img src="images/batangas.png" alt="" style="width: 25px; margin-right: 10px; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3); border-radius: 50%">
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="font-size: 1.5rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Document History</li>
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


</body>
<?php
include('connection.php');

// Check if the 'pno' query parameter is set
if (isset($_GET['pno'])) {
    // Get the 'pno' value from the query parameter
    $pno = $_GET['pno'];

    // Perform a search in your database based on the 'pno' value
    $query = mysqli_query($conn, "SELECT * FROM activity_log WHERE pno = '$pno' ORDER BY timestamp DESC");

    echo "<div class='table-container'>
            <div class='scroll-content'>
                <table>
                    <tr class='head'>
                        <th class='part'>PARTICULARS</th>
                        <th>PAPERTYPE</th>
                        <th>AMOUNT</th>
                        <th>EVENT DATE</th>
                        <th>STATUS</th>
                        <th>OFFICE</th>
                        <th>COMMENTS</th>
                        <th>EMANATE NO.</th>
                        <th>PR NO.</th>
                        <th>PR DATE</th>
                        <th>PO NO.</th>
                        <th>PO DATE</th>
                        <th>PERSON</th>
                        <th>ADMIN</th>
                        <th>ACTIVITY</th>
                        <th>TIME</th>
                        <th style='width: 5%'>ACTIONS</th>
                    </tr>
                    <tbody>";

                    $rowCount = mysqli_num_rows($query);
                    $currentRowNumber = 0;
                
                    while ($row = mysqli_fetch_array($query)) {
                        $currentRowNumber++;
                
                        @session_start(); // Start the session (if not started already)
                    
                        echo "<tr>
                        <td>" . $row["particulars"] . "</td>
                        <td class='paper'>" . $row["papertype"] . "</td>
                        <td class='paper'>" . (($row["amount"] != 0) ? number_format($row["amount"], 2, '.', ',') : '') . "</td>
                        <td class='paper'>" . $row["Edate"] . "</td>
                        <td class='paper'>" . $row["status"] . "</td>
                        <td class='paper'>" . $row["office"] . "</td>
                        <td class='paper'>" . $row["comments"] . "</td>
                        <td class='paper'>" . $row["Eno"] . "</td>
                        <td class='paper'>" . $row["PRno"] . "</td>
                        <td class='paper'>" . $row["PRdate"] . "</td>
                        <td class='paper'>" . $row["POno"] . "</td>
                        <td class='paper'>" . $row["POdate"] . "</td>
                        <td>" . $row["person"] . "</td>
                        <td>" . $row["admin"] . "</td>
                        <td>" . $row["activity_description"] . "</td>
                        <td class='paper'>" . date('m/d/Y h:i A', strtotime($row["timestamp"])) . "</td>

                        <td>";

                        // Check if the user is logged in and is an admin (you'll need to replace 'admin_username' with your actual admin username)
                        if (isset($_SESSION['username']) && $_SESSION['username'] === 'KikoAdmin') {
                            // Display delete button only for rows between the first and last
                            if ($currentRowNumber === 1 || $currentRowNumber === $rowCount) {
                                echo "<button type='button' class='del' disabled>Delete<i class='fas fa-trash-alt'></i></button>";
                            } else {
                                echo "<button type='button' class='del' onclick='confirmAndDelete(" . $row['id'] . ")' style='cursor: pointer;'>Delete<i class='fas fa-trash-alt'></i></button>";
                        }
                    }
                
                        echo "</td>
                              </tr>";
                    }
                    
                    echo "</tbody>
                          </table>
                        </div>
                      </div>";
                    } else {
                        echo 'No search query provided.';
                    }
                    ?>
                    

<script>
    function goBack() {
      history.back();
    }

    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        event.preventDefault(); // Prevent other potential actions associated with the Escape key
        goBack();
      }
    });

    function confirmAndDelete(id) {
        if (confirm("Are you sure you want to delete this entry?")) {
            // AJAX request to delete_logs.php
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_logs.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Optionally handle the response here
                    // For example, you can update the UI or display a message
                }
            };
            xhr.send('id=' + id);

            // Reload the page or update UI as needed
            location.reload();
        }
    }
  </script>

</html>
