<!DOCTYPE html>
<html>

<style>

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


.action-links-column {
    display: flex;
    align-items: center;
}

.action-links a {
    font-size: 13px;
    margin-left: 3px; /* Adjust the right margin */
    text-decoration: none;
    color: black;
    font-weight: bold;
    display: flex; /* Use flexbox for layout */
    align-items: center; /* Center icon vertically */
    padding: 8px 12px ; /* Adjust the padding (top/bottom, left/right) */
    margin-bottom: -10px;
}

.action-links i {
    margin-left: 5px;
    color: #2667a0; /* Adjust the icon color as needed */
}

.action-links i.fa-check-square {
    margin-left: 18px; /* Adjust the left margin for the checklist icon */
    color: green; /* Adjust the icon color as needed */
}

.back-buttonn {
        background-color: #2667a0;
        color: white;
        padding: 5px;
        padding-left: 20px;
        padding-right: 20px;
        border-radius: 5px;
        margin-left: 10px;
        margin-bottom: 10px;
        margin-top: 80px;
    }
</style>

<head>
    <title>PTCAO</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="images/batangas.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <nav class="navbar" style="display: flex; align-items: center; justify-content: space-between;">
        <div class="navbar-left" style="display: flex; align-items: center;">
            <img src="images/batangas.png" alt="" style="width: 25px; margin-right: 10px; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3); border-radius: 50%">
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="font-size: 1.5rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">PTCAO PAPERTRAIL</li>
            </ul>
        </div>
        <div class="navbar-right" style="visibility: hidden">
            <button id="login-button" class="btn">
                <p style="margin-right: 10px; cursor: pointer;"><u>Login</u></p>
                <img src="images/nobg.png" alt="" style="width: 20px;">
            </button>
        </div>
    </nav>

    <a href="admin.php">
<button class="back-buttonn">Back</button></a>


<?php
include('connection.php');
$query = "SELECT * FROM future ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="tabs scroll-content" style="overflow: auto; margin-top: 0">
    <table class="table">
        <thead class="tabs_name" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
            <th style="width: 30%">PARTICULARS</th>
            <th style="width: 15%">AMOUNT</th>
            <th style="width: 5%">YEAR</th>
            <th style="width: 5%">RESP. CENTER (RC)</th>
            <th style="width: 20%">ACCOUNT TYPE</th>
        </thead>
        <tbody>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <tr>
                        <td><?php echo $row['particulars']; ?></td>
                        <td style="text-align:right"><?php $amount = $row['amount']; if ($amount != 0) {echo number_format($amount, 2);}?></td>
                        <td style="text-align:center"><?php echo $row['taon']; ?></td>
                        <td style="text-align:center; font-size: 13px;"><?php echo $row['resp_center']; ?></td>
                        <td style="text-align:center; font-size: 13px;"><?php echo $row['account_type']; ?></td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='5'>No data found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

            </tbody>
        </table>
    </div>
        
            <div style="display: inline-block; position: absolute; right: 20px; ">
                <a href="programmers.php"><p style="display: inline-block; color: #2667a0"><u>2023</u></p></a>
                <a href="programmers.php" style="display: inline-block; "><img src="images/copyright.png" style=" width: 15px; ; "></a>
            </div>
        
            <div id="imageModal" class="modal">
                <span class="close" onclick="closeImageModal()">&times;</span>
                <img class="modal-content" id="modalImage">
            </div>
            <div id="modal-overlay"></div>
        
            <script>
                // JavaScript logic goes here
                document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        event.preventDefault();
        window.location.href = 'admin.php'; // Redirect to admin.php when Escape key is pressed
      }
    });
            </script>
        </body>
        
        </html>
