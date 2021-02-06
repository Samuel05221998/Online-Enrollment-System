<?php
    require_once('../enrollmentclass.php');

    $sycode = " ";
    if(empty($_GET['sycode'])) {
        $sycode = null;
    } else {
        $sycode = $_GET['sycode'];
    }
    // $id = $_GET['id'];
    $userdetails = $olenrollment->get_userdata();
    $viewOpenSY = $olenrollment->getOpenSY();
    $schoolyear = $olenrollment->getSchoolYear();
    $showenrolleyear = $olenrollment->showEnrolledYear($sycode);

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
                                <a href="enrollaccount.php?sycode=<?= $viewOpenSY['sycode'] ?>" class="collapse_sublink">Enrollment&nbsp;History</a>
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
                <h2>Enrollment History</h2>
                <label><?= (isset($sycode)) ? $sycode : '' ?></label>
            </div>
            <form method="GET" action="enrollmenthistory.php">
                <select name="sycode" id="">
                <?php foreach($schoolyear as $row) { ?>
                    <option value="<?= $row['sycode'] ?>" <?= ($row['sycode']=="$sycode") ? 'selected' : ' '; ?>><?= $row['sycode'] ?></option>
                <?php } ?>
                </select>
                <input type="submit" class="btn-submit">
            </form>
            <table class="table">
                <thead>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Year Level</th>
                    <th>Term</th>
                    <th>Course</th>
                    <th>Section Name</th>
                    <th>Fee Type</th>
                    <th>Status</th>
                    <th>Options</th>
                </thead>
                <tbody>
                    <?php if(is_array($showenrolleyear) || is_object($showenrolleyear))  {?>
                    <?php foreach($showenrolleyear as $row) {?>
                    <tr>
                        <td><?= $row['studentid'] ?></td>
                        <td><?= $row['studentname'] ?></td>
                        <td><?= $row['yearlevel'] ?></td>
                        <td><?= $row['term'] ?></td>
                        <td><?= $row['coursecode'] ?></td>
                        <td><?= $row['section_name'] ?></td>
                        <td><?= $row['feetype'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td>
                            <div class="opt_btn">
                                <form action="editSchedule.php" method="POST">
                                    <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                </form>
                                <form action="" method="POST">
                                    <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $schedule['subject_code']; ?> ?');">
                                </form>
                                <form action="printStudent.php" method="GET">
                                    <input type="submit" class="btn-submit" value="PRINT">
                                    <input type="hidden" name="sycode" id="" value="<?= $row['sycode'] ?>">
                                    <input type="hidden" name="section_id" id="" value="<?= $row['section_id'] ?>">
                                    <input type="hidden" name="student_id" id="" value="<?= $row['student_id'] ?>">
                                    <input type="hidden" name="coursecode" value="<?= $row['coursecode'] ?>">
                                    <input type="hidden" name="yearlevel" value="<?= $row['yearlevel'] ?>">
                                    <input type="hidden" name="term" value="<?= $row['term'] ?>">
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } else { echo "No Data"; }?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modal.js"></script>
</body>
</html>