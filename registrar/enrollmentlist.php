<?php
    require_once('../enrollmentclass.php');
    

    $sycode = " ";
    if(empty($_GET['sycode'])) {
        $sycode = null;
    } else {
        $sycode = $_GET['sycode'];
    }

    $coursecode = " ";
    if(empty($_GET['coursecode'])) {
        $coursecode = '%';
    } else {
        $coursecode = $_GET['coursecode'];
    }

    $viewenrollstudents = $olenrollment->viewEnrollStudents($sycode,$coursecode);
    $viewOpenSY = $olenrollment->getOpenSY();
    $courses = $olenrollment->getCourse();

    $userdetails = $olenrollment->get_userdata();
    // $id = $_GET['id'];

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
                <h2>Manage Enrollment</h2>
                <label><?= $sycode ?></label>
            </div>
            <form method="GET" action="enrollmentlist.php">
            <input type="hidden" name="sycode" value="<?= $sycode ?>">
            <select name="coursecode" id="">
            <option value="%">All Courses</option>
                <?php foreach($courses as $course) { ?>
                    <option value="<?= $course['course_code'] ?>" <?= ($course['course_code']=="$coursecode") ? 'selected' : ' '; ?>><?= $course['course_code'] ?></option>
                <?php } ?>
            </select>
            <input type="submit" class="btn-submit" name="Edit" value="Load Data">
            </form>
            <table class="table">
                <thead>
                    <th>No.</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>School Year</th>
                    <th>Course</th>
                    <th>Year Level</th>
                    <th>Term</th>
                    <th>Section</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Option</th>
                </thead>
                <tbody>
                <?php $i = 0; ?>
                        <?php if(is_array($viewenrollstudents) || is_object($viewenrollstudents))  {?>
                        <?php foreach($viewenrollstudents as $viewenrollstudent) {?>
                            <?php $i += 1; ?>       
                            <tr>
                            <td data-label="No."><?php echo $i ?></td>  
                                <td><?= $viewenrollstudent['student_id']; ?></td>
                                <td><?= $viewenrollstudent['studentname']; ?></td>
                                <td><?= $viewenrollstudent['sycode']; ?></td>
                                <td><?= $viewenrollstudent['coursecode']; ?></td>
                                <td><?=  $viewenrollstudent['yearlevel']; ?></td>
                                <td><?= $viewenrollstudent['term']; ?></td>
                                <td><?= $viewenrollstudent['section_name']; ?></td>
                                <td><?= date("m/d/Y",strtotime($viewenrollstudent['date_added'])); ?></td>
                                <td><?= $viewenrollstudent['status']; ?></td>
                                <td>
                                    <div class="opt_btn">
                                        <form action="" method="POST">
                                            <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $schedule['subject_code']; ?> ?');">
                                        </form>
                                        <form action="printStudent.php" method="GET">
                                            <input type="submit" class="btn-submit" value="PRINT">
                                            <input type="hidden" name="sycode" id="" value="<?= $viewenrollstudent['sycode'] ?>">
                                            <input type="hidden" name="section_id" id="" value="<?= $viewenrollstudent['section_id'] ?>">
                                            <input type="hidden" name="student_id" id="" value="<?= $viewenrollstudent['student_id'] ?>">
                                            <input type="hidden" name="coursecode" value="<?= $viewenrollstudent['coursecode'] ?>">
                                            <input type="hidden" name="yearlevel" value="<?= $viewenrollstudent['yearlevel'] ?>">
                                            <input type="hidden" name="term" value="<?= $viewenrollstudent['term'] ?>">
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
</body>
</html>