<?php
session_start();
?>

<!DOCTYPE>
<html>
    <head>
        <title>Login Form</title>
        <link rel="stylesheet" href="styles/login_style.css" media="all"/>
    </head>
<body>

    <div class="login">
        <h2 style="color: white; text-align: center"><?php echo @$_GET['not _admin']; ?></h2>
        <h2 style="color: white; text-align: center"><?php echo @$_GET['not logged_out']; ?></h2>

        <h1>Admin Login</h1>
        <form method="post" action="login.php">
            <input type="text" name="email" placeholder="Email" required="required" />
            <input type="password" name="password" placeholder="Password" required="required" />
            <button type="submit" class="btn btn-primary btn-block btn-large" name="login">LogIn</button>
        </form>
    </div>
</body>
</html>

<?php

include("includes/db.php");
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = mysqli_real_escape_string($con, $_POST['password']);

    $sel_user = "select * from admins where user_email='$email' AND user_pass='$pass'";
    $run_user = mysqli_query($con, $sel_user);

    $check_user = mysqli_num_rows($run_user);
    if ($check_user == 0) {
        echo "<script>alert('Password or Email is wrong, try again!')</script>";
    } else {
        $_SESSION['user_email']=$email;
        echo "<script>window.open('index.php?logged_in=You have successfully Logged in!')</script>";
    }
}


?>