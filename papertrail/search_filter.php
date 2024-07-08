<!DOCTYPE html>
<html>

<style>

    h2{
        justify-content: center;
        text-align: center;
    }

    .table-container{
        margin-left: 10px;
        margin-right: 10px;
        height: 70vh;
        max-height: 700px;

        
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
    .scroll-content{
        overflow: auto;
        height: 88vh;
        max-height: 725px;
        border-bottom: 3px solid #d3d3d3;
        border-right: 3px solid #d3d3d3;
        border-left: 3px solid #d3d3d3;
        border-bottom: 5px solid #2667a0;
        background-color: white;
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
<nav class="navbar" style="display: flex; align-items: center; justify-content: space-between; ">
    <div class="navbar-left" style="display: flex; align-items: center;">

    <img src="images/batangas.png" alt="" style="width: 25px; margin-right: 10px; box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3); border-radius: 50%">
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="font-size: 1.5rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Search Result:</li>
        </ul>
    </div>

    <div class="navbar-right" style="visibility: hidden;">
        
        <button id="login-button" class="btn" >
        <p style="margin-right: 10px;"><u>Login</u></p>
            <img src="images/nobg.png" alt="" style="width: 20px;">
        </button>
    </div>
</nav>

<a href="filter.php">
<button class="back-buttonn">Back</button></a>


</body>

<?php
include('connection.php');

$limit = 13
 ; // Number of records per page

if (isset($_GET['query'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['query']);

    $query = "SELECT * FROM details WHERE 
    particulars LIKE '%$searchTerm%' OR
    papertype LIKE '%$searchTerm%' OR
    amount LIKE '%$searchTerm%' OR
    Edate LIKE '%$searchTerm%' OR
    status LIKE '%$searchTerm%' OR
    office LIKE '%$searchTerm%' OR
    comments LIKE '%$searchTerm%' OR
    Eno LIKE '%$searchTerm%' OR
    PRno LIKE '%$searchTerm%' OR
    PRdate LIKE '%$searchTerm%' OR
    POno LIKE '%$searchTerm%' OR
    POdate LIKE '%$searchTerm%' OR
    person LIKE '%$searchTerm%' OR
    admin LIKE '%$searchTerm%' OR
    timestamp LIKE '%$searchTerm%'
    ORDER BY timestamp DESC";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Pagination logic
    $totalRows = mysqli_num_rows($result);
    $totalPages = ceil($totalRows / $limit);
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $startFrom = ($currentPage - 1) * $limit;

    $queryWithLimit = $query . " LIMIT $startFrom, $limit";
    $resultWithLimit = mysqli_query($conn, $queryWithLimit);

    if ($resultWithLimit && mysqli_num_rows($resultWithLimit) > 0) {
        echo "<div class='table-container'>
            <div class='scroll-content'>
                <table>
                <tr class='head'>
                    <th style='width: 7%'>ACTIONS</th>
                    <th class='part'>PARTICULARS</th>
                    <th>PAPERTYPE</th>
                    <th>AMOUNT</th>
                    <th>EVENT DATE</th>
                    <th>STATUS</th>
                    <th>OFFICE</th>
                    <th>PERSON</th>
                    <th>ADMIN</th>
                    <th>DATE UPDATE</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($resultWithLimit)) {
            // Row coloring logic
            $ageInSeconds = time() - strtotime($row['timestamp']);
            $rowClass = '';
            if ($row['status'] === 'Problem') {
                $rowClass = 'problem-row';
            } elseif ($row['status'] === 'Complete') {
                $rowClass = 'completed-row';
            } elseif ($ageInSeconds > 30 * 24 * 60 * 60) {
                $rowClass = 'month-row';
            } elseif ($ageInSeconds > 7 * 24 * 60 * 60) {
                $rowClass = 'week-row';
            }

            // Outputting table rows with proper classes
            echo "<tr class='$rowClass'>";
            echo "<tr class='$rowClass'>";
            echo "<td>
                <a href='attachment_home.php?pno=$pno' style='font-size: 13px; margin-left: 18px; text-decoration: none; color: black; font-weight: bold;'>Attachment<i class='fas fa-paperclip fa-sm' style='margin-left: 5px; color: #2667a0'></i></a>
                <a href='checklist_home.php?id={$row['id']}' style='font-size: 13px; margin-left: 18px; text-decoration: none; color: black; font-weight: bold;'>Checklist<i class='fas fa-check-square fa-sm' style='margin-left: 18px; color: green'></i></a>
            </td>";
        
            // Continue this structure for other columns
            echo "<td>
            <a href='activity_log.php?pno=" . urlencode($row['pno']) . "' style='color: #126dbc; text-decoration: none; margin-left: 5px'>
                {$row['particulars']}
            </a>
        </td>";
        echo "<td class='paper'>{$row['papertype']}</td>";
        
        // Check if the amount is zero before displaying the <td>
        
        if ($row['amount'] != 0) {
            echo "<td class='paper'>" . number_format($row['amount'], 2, '.', ',') . "</td>";
        } else {
            echo "<td class='paper'></td>"; // Display an empty cell if amount is zero
        }
        
        echo "<td class='paper'>{$row['Edate']}</td>";
        echo "<td class='paper'>{$row['status']}</td>";
        echo "<td class='paper' style='font-size: 13px'>{$row['office']}</td>";
        echo "<td class='paper' style='font-size: 13px'>{$row['person']}</td>";
        echo "<td class='paper' style='font-size: 13px'>{$row['admin']}</td>";
        echo "<td class='paper' style='font-size: 13px'>" . date('d/m/Y h:i A', strtotime($row['timestamp'])) . "</td>";
        echo "</tr>";
        }
        echo "</table></div></div>";

        // Pagination links
        echo "<div class='pagination' style='margin-top: 5%;'>";

        // Display left arrow
        if ($currentPage > 1) {
            echo "<a href='search_filter.php?query=$searchTerm&page=" . ($currentPage - 1) . "'>&lt;</a>";
        } else {
            // If on the first page, make the "Previous" button go to the last page
            echo "<a href='search_filter.php?query=$searchTerm&page=$totalPages'>&lt;</a>";
        }

        // Display five visible pages
        $startPage = max(1, min($currentPage - 2, $totalPages - 4));
        $endPage = min($totalPages, $startPage + 4);

        for ($i = $startPage; $i <= $endPage; $i++) {
            $bgColor = ($i == $currentPage) ? '' : '';
        
            echo "<li >";
            
            if ($i == $currentPage) {
                echo "<li class='current'><a href='search_filter.php?query=$searchTerm&page=$i' >$i</a></li>";
            } else {
                echo "<a href='search_filter.php?query=$searchTerm&page=$i'>$i</a>";
            }
        
            echo "</li>";
        }

        // Display right arrow
        if ($currentPage < $totalPages) {
            echo "<a href='search_filter.php?query=$searchTerm&page=" . ($currentPage + 1) . "'>&gt;</a>";
        } else {
            // If on the last page, make the "Next" button go to the first page
            echo "<a href='search_filter.php?query=$searchTerm&page=1'>&gt;</a>";
        }

        echo "</div>";
    } else {
        echo "No results found.";
    }

    mysqli_close($conn);
}
?>
<script>

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
        event.preventDefault();
        window.location.href = 'home.php'; // Redirect to admin.php when Escape key is pressed
      }
    });
    </script>   
</body>

</html>