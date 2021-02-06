<?php
    require_once('../enrollmentclass.php');
    
    // $id = $_GET['id'];
    $userdetails = $olenrollment->get_userdata();
    $viewOpenSY = $olenrollment->getOpenSY();

    if(isset($userdetails)) {
        if($userdetails['position'] != "Registrar") {

            header("Location: ../login.php");
        }
    } else {
        header("Location: ../login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <title>Online Enrollment System</title>
    <link rel="stylesheet" href="../css/registrar.css">
</head>
<body>
    <header>
        <div class="logo">
            <h4>Online Enrollment System</h4>
        </div>
        <ul class="nav-links">
            <li>
                <li><a href="#"><?=$userdetails['deptname']." "."(".$userdetails['position'].")" ?></a></li>    
            </li>
        </ul>
    </header>
    <div id="body-pd">
    <div class="l-navbar" id="navbar">
            <div class="nav">
                <div>
                    <div class="nav_brand">
                        <img src="./../images/list-view.ico" class="nav_toggle" id="nav-toggle"></img> <a href="#" class="nav_logo">STI</a>
                    </div>
                    <div class="nav_list">
                        <a href="index.php" class="nav_link active">
                            <img src="./../images/home-2.ico" class="nav_icon"></img>
                            <span class="nav_name">Dashboard</span>
                        </a>
                        <div class="nav_link collapse">
                            <img src="./../images/enrollment.ico" class="nav_icon"></img>
                            <span class="nav_name">Enrollment</span>
                            <img src="./../images/arrow-2.ico" class="collapse_link"></img>
                            <ul class="collapse_menu">
                                <a href="enrollment.php" class="collapse_sublink">Add&nbsp;Enrollment</a>
                                <a href="enrollmentlist.php?sycode=<?= $viewOpenSY['sycode'] ?>" class="collapse_sublink">Enrollment&nbsp;List</a>
                                <a href="unenrolllist.php?sycode=<?= $viewOpenSY['sycode'] ?>" class="collapse_sublink">Unenrollment&nbsp;List</a>
                                <a href="enrollmenthistory.php?sycode=<?= $viewOpenSY['sycode'] ?>" class="collapse_sublink">Enrollment&nbsp;History</a>
                            </ul>
                        </div>
                        <div class="nav_link collapse">
                            <img src="./../images/folder-2.ico" class="nav_icon"></img>
                            <span class="nav_name">Manage Student</span>
                            <img src="./../images/arrow-2.ico" class="collapse_link"></img>
                            <ul class="collapse_menu">
                                <a href="addstudent.php" class="collapse_sublink">Add&nbsp;Student</a>
                                <a href="list_students.php" class="collapse_sublink">List&nbsp;of&nbsp;Students</a>
                                <a href="archiveStudent.php" class="collapse_sublink">Archived&nbsp;Students</a>
                                <a href="studentsaccount.php" class="collapse_sublink">Student&nbsp;Account</a>
                            </ul>
                        </div>
                        <a href="payment.php" class="nav_link">
                            <img src="./../images/database.ico" class="nav_icon"></img>
                            <span class="nav_name">Payment History</span>
                        </a>
                        <a href="#" class="nav_link">
                            <img src="./../images/settings.ico" class="nav_icon"></img>
                            <span class="nav_name">Settings</span>
                        </a>
                    </div>
                </div>
                <a href="logout.php" class="nav_link" onclick="return confirm('Are you sure you want to logout?');">
                    <img src="./../images/logout.ico" class="nav_icon"></img>
                    <span class="nav_name">Logout</span>
                </a>
            </div>
        </div>
        <div class="right-side">
            <div class="enroll-main-container">
                <h2>Open Semester</h2>
                <label><?= $viewOpenSY['sycode'] ?></label>
            </div>
            
        </div>
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modal.js"></script>
</body>
</html>