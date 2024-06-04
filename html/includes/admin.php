<?php
require('dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM `admin` WHERE email='$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        if (password_verify($password, $admin['password'])) {
            session_start();
            $_SESSION['admin'] = $admin;
            $msg = "Admin login successful";
            header("location: http://localhost/project/html/admin/dashboard.php?msg=$msg");
        } else {
            $msg = "Incorrect password";
        }
    } else {
        $msg = "Admin not found";
    }

    header("location: http://localhost/project/html/forms/admin.php?msg=$msg");
}
?>
