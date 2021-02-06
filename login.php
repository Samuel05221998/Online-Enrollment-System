<?php
    require_once('enrollmentclass.php');
    $olenrollment->login();
    // $olenrollment->verified();
    $userdetails = $olenrollment->get_userdata();
    $viewOpenSY = $olenrollment->getOpenSY();

    function pathTo($destination) {
        echo "<script>window.location.href='/Online_Enrollment_System/$destination.php'</script>";
    }

    if(isset($userdetails)) {
        // if($_SESSION['position'] == null || empty($_SESSION['position'])) {
        //     /* Set Default Invalid */
        //     $_SESSION['status'] = null;
        // }
        if($userdetails['position'] == "Administrator") {

            pathTo('admin/index');
        }
        if($userdetails['position'] == "Registrar") {

            pathTo('registrar/index');
        }
        if($userdetails['position'] == "Student") {

            pathTo('student/index');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <title>Online Enrollment System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <div class="logo">
            <h4>Online Enrollment System</h4>
        </div>
        <ul class="nav-links">
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>
                <a href="about.php">About</a>
            </li>
            <li>
                <a href="enroll_now.php">Online Registration</a>
            </li>
            <li>
                <a href="login.php">Login</a>
            </li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>
    <div class="hero">
        <div class="banner">
            <h1 class="banner-title">Login Form</h1>
                <form action="login.php" method="post">
                    <div class="login">
                        <h2>Username</h2>
                        <input type="text" name="username" class="login_form" id="" autocomplete="off">
                        <h2>Password</h2>
                        <input type="password" name="password" class="login_form" id="" autocomplete="off">
                        <input type="submit" class="banner-btn" name="login" value="LOGIN">
                        <input type="hidden" name="sycode" value="<?= $viewOpenSY['sycode']; ?>">

                        <h3 align = "center" style = "color: red;"> <?= @$_GET["invalid"]; ?></h3>
                        <h3 align = "center" style = "color: blue;"> <?= @$_GET["logout"]; ?></h3>
                    </div>
                </form>
        </div>
    </div>
    <footer id="login-footer">
        <p>Copyright &copy; 2020 Online Enrollment System</p>
    </footer>
    <script src="js/index.js"></script>
</body>
</html>