<?php
session_start();
include('connection.php');

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Get the role from the form

    // Place the "Remember Me" code here so it sets the cookie after form submission
    if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {
        // Set a cookie to remember the username (no expiration time)
        setcookie('remember_me_username', $_POST['username'], 0, '/');
        setcookie('remember_me_password', $_POST['password'], 0, '/');
    }

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role; // Set the role in the session
        header("Location: admin.php");
        exit();
    } else {
        echo "<script>alert('Invalid username, password, or role.');</script>";
    }
}

mysqli_close($conn);
?>
