<!DOCTYPE html>
<html>
<head>
    <title>Add Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="images/batangas.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .main-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start; /* Align containers to the top */
        padding: 0 20px; /* Add some padding to the sides */
        }
        .container{
            background-color: white;
            width: 30%;
            height: 31vh;
            padding: 20px;
            margin-top: 3%;
            border-radius: 5px;
            box-shadow: 8px 12px 16px 0px rgba(0, 0, 0, .2);
            display: inline-block;
            margin-left: 7%;
        }
        .additional-container {
        background-color: white;
        width: 48%; /* Adjust the width as needed */
        height: 80vh;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 8px 12px 16px 0px rgba(0, 0, 0, .2);
        position: absolute;
        margin-left: 32%;
        margin-top: -16.1%;
        }

        h1{
            color: #2667a0;
            margin-top: -1px;
        }

        label{
            font-size: 20px;
        }

        .box{
            width: 97.5%;
            padding: 5px;
            font-size: 20px;
            border-radius: 5px;
            border: 1px solid #838384;
        }

        .sub{
            width: 100%
        }

        .password-container {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 70%;
        transform: translateY(-50%);
        cursor: pointer;
    }

    a{
        display: flex;
        color: black; 
        text-decoration: none; 
        background-color: transparent; 
        padding: 7px; 
        width: 97%;
        border-radius: 4px; 
        border: 2px solid black;
        text-align: center;
        justify-content: center;
        margin-top: 10px;
    }
        .delete-btn {
        text-decoration: none;
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        padding: 5px 10px;
        border-radius: 3px;
    }

    .del{
        border: none;
        outline: none;
        margin-left: -5px;
    }

    .fas{
        width: 20px;
        color: red;
        margin-left: 3px;
    }

    </style>
</head>
<body>

<div class="main-container">
    <div class="container">
    <h1>Add Account</h1>
    <form method="post" action="process_account.php">
        <label for="username">Username:</label><br>
        <input style="margin-bottom: 10px;" class="box" type="text" id="username" name="username"  placeholder="Enter username" required><br>
        
        <div class="password-container">
        <label for="password">Password:</label><br>
        <input class="box" type="password" id="password" name="password"  placeholder="Enter password" required>

        <span class="toggle-password" onclick="togglePasswordVisibility()">
            <i id="toggleIcon" class="fa fa-eye-slash"></i>
        </span>
        </div><br>

        <input type="hidden" name="role" value="admin"> <!-- Added input field for role -->
        <input class="sub" type="submit" value="Create Account"><br>
        <a href="admin.php">Back</a>
        <div class="additional-container">
            <h1>Accounts</h1>
            <table border="1" class="tabss scroll-content" style="border-radius: 5px;">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Password</th>
                        <th style="width: 10%; ">Actions</th>
                    </tr>
                </thead>
                <tbody style="border-radius: 5px;">
                <?php
                include('connection.php');

                // Query to fetch username and password from the database
                $sql = "SELECT id, username, password FROM users"; // Replace 'your_table_name' with your actual table name

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row["username"] . "</td>
                            <td>" . $row["password"] . "</td>
                            <td><a href='delete_account.php?id=" . $row['id'] . "' class='del'>Delete <i class='fas fa-trash-alt'></i></a></td>
                        </tr>";
                    }
                } else {
                    echo "<tr>
                        <td colspan='3'>No accounts found</td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    </form>
</body>
</html>

<script>
    // Function to toggle password visibility
    function togglePasswordVisibility() {
        var passwordField = document.getElementById("password");
        var toggleIcon = document.getElementById("toggleIcon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.className = "fa fa-eye";
        } else {
            passwordField.type = "password";
            toggleIcon.className = "fa fa-eye-slash";
        }
    }
</script>
