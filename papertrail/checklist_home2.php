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

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // If a checkbox is checked or unchecked and form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['item'])) {
            foreach ($_POST['item'] as $id => $data) {

                $comment1 = $data['comment1'];
                $comment2 = $data['comment2'];
                $comment3 = $data['comment3'];
                $comment4 = $data['comment4'];
                $comment5 = $data['comment5'];
                $comment6 = $data['comment6'];
                $comment7 = $data['comment7'];
                $comment8 = $data['comment8'];
                $comment9 = $data['comment9'];
                $comment10 = $data['comment10'];
                $comment11 = $data['comment11'];
                $comment12 = $data['comment12'];
                $comment13 = $data['comment13'];
                $comment14 = $data['comment14'];
                $comment15 = $data['comment15'];
                $comment16 = $data['comment16'];
                $comment17 = $data['comment17'];
                $comment18 = $data['comment18'];
                $comment19 = $data['comment19'];
                $comment20 = $data['comment20'];
                $comment21 = $data['comment21'];
                $comment22 = $data['comment22'];

                $updateCommentQuery = "UPDATE details 
                SET comment1 = '$comment1', comment2 = '$comment2', comment3 = '$comment3', comment4 = '$comment4',
                comment5 = '$comment5', comment6 = '$comment6', comment7 = '$comment7', comment8 = '$comment8',
                comment9 = '$comment9', comment10 = '$comment10', comment11 = '$comment11', comment12 = '$comment12', 
                comment13 = '$comment13', comment14 = '$comment14', comment15 = '$comment15', comment16 = '$comment16',
                comment17 = '$comment17', comment18 = '$comment18', comment19 = '$comment19', comment20 = '$comment20'
                , comment21 = '$comment21', comment22 = '$comment22' WHERE id = $id";

                $conn->query($updateCommentQuery);

                $timestamp1 = $data['timestamp1'];
                $timestamp2 = $data['timestamp2'];
                $timestamp3 = $data['timestamp3'];
                $timestamp4 = $data['timestamp4'];
                $timestamp5 = $data['timestamp5'];
                $timestamp6 = $data['timestamp6'];
                $timestamp7 = $data['timestamp7'];
                $timestamp8 = $data['timestamp8'];
                $timestamp9 = $data['timestamp9'];
                $timestamp10 = $data['timestamp10'];
                $timestamp11 = $data['timestamp11'];
                $timestamp12 = $data['timestamp12'];
                $timestamp13 = $data['timestamp13'];
                $timestamp14 = $data['timestamp14'];
                $timestamp15 = $data['timestamp15'];
                $timestamp16 = $data['timestamp16'];
                $timestamp17 = $data['timestamp17'];
                $timestamp18 = $data['timestamp18'];
                $timestamp19 = $data['timestamp19'];
                $timestamp20 = $data['timestamp20'];
                $timestamp21 = $data['timestamp21'];
                $timestamp22 = $data['timestamp22'];

                $updatetimestampQuery = "UPDATE details 
                SET timestamp1 = '$timestamp1', timestamp2 = '$timestamp2', timestamp3 = '$timestamp3', timestamp4 = '$timestamp4',
                timestamp5 = '$timestamp5', timestamp6 = '$timestamp6', timestamp7 = '$timestamp7', timestamp8 = '$timestamp8', timestamp9 = '$timestamp9', timestamp10 = '$timestamp10',
                timestamp11 = '$timestamp11', timestamp12 = '$timestamp12', timestamp13 = '$timestamp13', timestamp14 = '$timestamp14',
                timestamp15 = '$timestamp15', timestamp16 = '$timestamp16', timestamp17 = '$timestamp17', timestamp18 = '$timestamp18'
                , timestamp19 = '$timestamp19', timestamp20 = '$timestamp20', timestamp21 = '$timestamp21', timestamp22 = '$timestamp22' WHERE id = $id";

                $conn->query($updatetimestampQuery);

                $check1 = isset($data['check1']) ? 1 : 0;
                $check2 = isset($data['check2']) ? 1 : 0;
                $check3 = isset($data['check3']) ? 1 : 0;
                $check4 = isset($data['check4']) ? 1 : 0;
                $check5 = isset($data['check5']) ? 1 : 0;
                $check6 = isset($data['check6']) ? 1 : 0;
                $check7 = isset($data['check7']) ? 1 : 0;
                $check8 = isset($data['check8']) ? 1 : 0;
                $check9 = isset($data['check9']) ? 1 : 0;
                $check10 = isset($data['check10']) ? 1 : 0;
                $check11 = isset($data['check11']) ? 1 : 0;
                $check12 = isset($data['check12']) ? 1 : 0;
                $check13 = isset($data['check13']) ? 1 : 0;
                $check14 = isset($data['check14']) ? 1 : 0;
                $check15 = isset($data['check15']) ? 1 : 0;
                $check16 = isset($data['check16']) ? 1 : 0;
                $check17 = isset($data['check17']) ? 1 : 0;
                $check18 = isset($data['check18']) ? 1 : 0;
                $check19 = isset($data['check19']) ? 1 : 0;
                $check20 = isset($data['check20']) ? 1 : 0;
                $check21 = isset($data['check21']) ? 1 : 0;
                $check22 = isset($data['check22']) ? 1 : 0;
                
                
                $updateItemQuery = "UPDATE details 
                                    SET check1 = $check1, check2 = $check2, check3 = $check3, 
                                    check4 = $check4, check5 = $check5, check6 = $check6, 
                                    check7 = $check7, check8 = $check8, check9 = $check9, 
                                    check10 = $check10, check11 = $check11, check12 = $check12, check13 = $check13,
                                    check14 = $check14, check15 = $check15, check16 = $check16, check17 = $check17
                                    , check18 = $check18, check19 = $check19, check20 = $check20, check21 = $check21
                                    , check22 = $check22 WHERE id = $id";

                $conn->query($updateItemQuery);
            }
        }
    }


    // Check if the ID is set in the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Retrieve checklist items for the specific ID from the database
        $itemQuery = "SELECT * FROM details WHERE id = $id";
        $itemResult = $conn->query($itemQuery);
    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Checklist</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <link rel="icon" type="image/x-icon" href="images/batangas.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <style>
            body{
                background-color: #d3d3d3;
                position: fixed;
            }

            table {
                border-collapse: collapse;
                width: 900px;
                border-bottom: 5px solid #2667a0;
            }

            th{
                background-color: #2667a0;
                color: #fff;
                text-align: center;
                padding: 10px;
            }

            .coms{
                width: 50%; 
            }

            td {
                border: 1px solid #2667a0;
                text-align: left;
                padding: 8px;
                
            }

            td{
                text-align: center;
            }

            .paper{
                text-align: left;
            }

            input{
                text-align: center;
                border: none;
                width: 100%;
            }

            .container{
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, .2);
                padding: 20px;
                width: 96%;
                margin-left: 48%;
                margin-top: 4%;
            }

            h3{
                margin-top: -2px;
            }

            .sub{
                padding: 10px;
                background-color: #2667a0;
                color: #fff;
                border-radius: 3px;
                margin-bottom: 10px;
                cursor: pointer;
            }

            button{
                width: 100%;
                padding: 5px;
                border: 1px solid #333;
                border-radius: 3px;
                cursor: pointer;
            }

            a{
                text-decoration: none;
                color: #333;
            }

        </style>
    </head>
    <body>

        <div class="container">

    <?php
    if (isset($itemResult) && $itemResult->num_rows > 0) {
        // Fetch the "particulars"
        $particularsQuery = "SELECT particulars FROM details WHERE id = $id";
        $particularsResult = $conn->query($particularsQuery);
        $particulars = $particularsResult->fetch_assoc()['particulars'];
        $particularsResult->free();

    // Display "particulars" as a header
    echo "<h3>Particular: $particulars</h3>";
        echo "<form method='post'>";
        echo "<table>";
        echo "<tr><th>Item</th><th class='coms'>Comment</th><th>Status</th><th>Time</th></tr>";

        while ($row = $itemResult->fetch_assoc()) {
            $id = $row['id'];

            $papertype1 = $row['papertype1'];
            $papertype2 = $row['papertype2'];
            $papertype3 = $row['papertype3'];
            $papertype4 = $row['papertype4'];
            $papertype5 = $row['papertype5'];
            $papertype6 = $row['papertype6'];
            $papertype7 = $row['papertype7'];
            $papertype8 = $row['papertype8'];
            $papertype9 = $row['papertype9'];
            $papertype10 = $row['papertype10'];
            $papertype11 = $row['papertype11'];
            $papertype12 = $row['papertype12'];
            $papertype13 = $row['papertype13'];
            $papertype14 = $row['papertype14'];
            $papertype15 = $row['papertype15'];
            $papertype16 = $row['papertype16'];
            $papertype17 = $row['papertype17'];
            $papertype18 = $row['papertype18'];
            $papertype19 = $row['papertype19'];
            $extra1 = $row['extra1'];
            $extra2 = $row['extra2'];
            $extra3 = $row['extra3'];

            $comment1 = $row['comment1'];
            $comment2 = $row['comment2'];
            $comment3 = $row['comment3'];
            $comment4 = $row['comment4'];
            $comment5 = $row['comment5'];
            $comment6 = $row['comment6'];
            $comment7 = $row['comment7'];
            $comment8 = $row['comment8'];
            $comment9 = $row['comment9'];
            $comment10 = $row['comment10'];
            $comment11 = $row['comment11'];
            $comment12 = $row['comment12'];
            $comment13 = $row['comment13'];
            $comment14 = $row['comment14'];
            $comment15 = $row['comment15'];
            $comment16 = $row['comment16'];
            $comment17 = $row['comment17'];
            $comment18 = $row['comment18'];
            $comment19 = $row['comment19'];
            $comment20 = $row['comment20'];
            $comment21 = $row['comment21'];
            $comment22 = $row['comment22'];

            $check1 = $row['check1'] ? 'checked' : '';
            $check2 = $row['check2'] ? 'checked' : '';
            $check3 = $row['check3'] ? 'checked' : '';
            $check4 = $row['check4'] ? 'checked' : '';
            $check5 = $row['check5'] ? 'checked' : '';
            $check6 = $row['check6'] ? 'checked' : '';
            $check7 = $row['check7'] ? 'checked' : '';
            $check8 = $row['check8'] ? 'checked' : '';
            $check9 = $row['check9'] ? 'checked' : '';
            $check10 = $row['check10'] ? 'checked' : '';
            $check11 = $row['check11'] ? 'checked' : '';
            $check12 = $row['check12'] ? 'checked' : '';
            $check13 = $row['check13'] ? 'checked' : '';
            $check14 = $row['check14'] ? 'checked' : '';
            $check15 = $row['check15'] ? 'checked' : '';
            $check16 = $row['check16'] ? 'checked' : '';
            $check17 = $row['check17'] ? 'checked' : '';
            $check18 = $row['check18'] ? 'checked' : '';
            $check19 = $row['check19'] ? 'checked' : '';
            $check20 = $row['check20'] ? 'checked' : '';
            $check21 = $row['check21'] ? 'checked' : '';
            $check22 = $row['check22'] ? 'checked' : '';

            $timestamp1 = $row['timestamp1'];
            $timestamp2 = $row['timestamp2'];
            $timestamp3 = $row['timestamp3'];
            $timestamp4 = $row['timestamp4'];
            $timestamp5 = $row['timestamp5'];
            $timestamp6 = $row['timestamp6'];
            $timestamp7 = $row['timestamp7'];
            $timestamp8 = $row['timestamp8'];
            $timestamp9 = $row['timestamp9'];
            $timestamp10 = $row['timestamp10'];
            $timestamp11 = $row['timestamp11'];
            $timestamp12 = $row['timestamp12'];
            $timestamp13 = $row['timestamp13'];
            $timestamp14 = $row['timestamp14'];
            $timestamp15 = $row['timestamp15'];
            $timestamp16 = $row['timestamp16'];
            $timestamp17 = $row['timestamp17'];
            $timestamp18 = $row['timestamp18'];
            $timestamp19 = $row['timestamp19'];
            $timestamp20 = $row['timestamp20'];
            $timestamp21 = $row['timestamp21'];
            $timestamp22 = $row['timestamp22'];

            echo "<tr>";
            echo "<td class='paper'>$papertype1</td>";
            echo "<td><input type='text' name='item[$id][comment1]' value='$comment1' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check1]' class='task-checkbox' $check1 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp1]' value='$timestamp1' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$papertype2</td>";
            echo "<td><input type='text' name='item[$id][comment2]' value='$comment2' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check2]' class='task-checkbox'  $check2 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp2]' value='$timestamp2' class='timestamp-input' readonly></td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td class='paper'>$papertype3</td>";
            echo "<td><input type='text' name='item[$id][comment3]' value='$comment3' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check3]' class='task-checkbox' $check3 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp3]' value='$timestamp3' class='timestamp-input' readonly></td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td class='paper'>$papertype4</td>";
            echo "<td><input type='text' name='item[$id][comment4]' value='$comment4' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check4]' class='task-checkbox' $check4 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp4]' value='$timestamp4' class='timestamp-input' readonly></td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td class='paper'>$papertype5</td>";
            echo "<td><input type='text' name='item[$id][comment5]' value='$comment5' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check5]' class='task-checkbox' $check5 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp5]' value='$timestamp5' class='timestamp-input' readonly></td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td class='paper'>$papertype6</td>";
            echo "<td><input type='text' name='item[$id][comment6]' value='$comment6' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check6]' class='task-checkbox' $check6 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp6]' value='$timestamp6' class='timestamp-input' readonly></td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td class='paper'>$papertype7</td>";
            echo "<td><input type='text' name='item[$id][comment7]' value='$comment7' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check7]' class='task-checkbox' $check7 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp7]' value='$timestamp7' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$papertype8</td>";
            echo "<td><input type='text' name='item[$id][comment8]' value='$comment8' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check8]' class='task-checkbox' $check8 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp8]' value='$timestamp8' class='timestamp-input' readonly></td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td class='paper'>$papertype9</td>";
            echo "<td><input type='text' name='item[$id][comment9]' value='$comment9' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check9]' class='task-checkbox' $check9 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp9]' value='$timestamp9' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$papertype10</td>";
            echo "<td><input type='text' name='item[$id][comment10]' value='$comment10' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check10]' class='task-checkbox' $check10 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp10]' value='$timestamp10' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$papertype11</td>";
            echo "<td><input type='text' name='item[$id][comment11]' value='$comment11' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check11]' class='task-checkbox' $check11 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp11]' value='$timestamp11' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$papertype12</td>";
            echo "<td><input type='text' name='item[$id][comment12]' value='$comment12' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check12]' class='task-checkbox' $check12 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp12]' value='$timestamp12' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$papertype13</td>";
            echo "<td><input type='text' name='item[$id][comment13]' value='$comment13' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check13]' class='task-checkbox' $check13 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp13]' value='$timestamp13' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$papertype14</td>";
            echo "<td><input type='text' name='item[$id][comment14]' value='$comment14' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check14]' class='task-checkbox' $check14 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp14]' value='$timestamp14' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$papertype15</td>";
            echo "<td><input type='text' name='item[$id][comment15]' value='$comment15' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check15]' class='task-checkbox' $check15 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp15]' value='$timestamp15' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$papertype16</td>";
            echo "<td><input type='text' name='item[$id][comment16]' value='$comment16' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check16]' class='task-checkbox' $check16 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp16]' value='$timestamp16' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$papertype17</td>";
            echo "<td><input type='text' name='item[$id][comment17]' value='$comment17' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check17]' class='task-checkbox' $check17 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp17]' value='$timestamp17' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$papertype18</td>";
            echo "<td><input type='text' name='item[$id][comment18]' value='$comment18' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check18]' class='task-checkbox' $check18 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp18]' value='$timestamp18' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$papertype19</td>";
            echo "<td><input type='text' name='item[$id][comment19]' value='$comment19' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check19]' class='task-checkbox' $check19 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp19]' value='$timestamp19' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$extra1</td>";
            echo "<td><input type='text' name='item[$id][comment20]' value='$comment20' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check20]' class='task-checkbox' $check20 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp20]' value='$timestamp20' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$extra2</td>";
            echo "<td><input type='text' name='item[$id][comment21]' value='$comment21' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check21]' class='task-checkbox' $check21 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp21]' value='$timestamp21' class='timestamp-input' readonly></td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class='paper'>$extra3</td>";
            echo "<td><input type='text' name='item[$id][comment22]' value='$comment22' readonly></td>";
            echo "<td><input type='checkbox' name='item[$id][check22]' class='task-checkbox' $check22 disabled></td>";
            echo "<td><input type='text' name='item[$id][timestamp22]' value='$timestamp22' class='timestamp-input' readonly></td>";
            echo "</tr>";
            
        }

        echo "</table>";
        echo "</form>";
        echo "<button onclick='javascript:history.back()' class='back-button'>Back</button>";
    } else {
        echo "<p>No checklist found for the specified ID.</p>";
    }
    ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        });
    </script>

</body>

</html>

