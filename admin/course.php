<?php
    require_once('../enrollmentclass.php');
    
    $userdetails = $olenrollment->get_userdata();
    $viewaccesses = $olenrollment->getAccess();
    $olenrollment->add_course($_POST);
    $courses = $olenrollment->getCourse();

    if(isset($userdetails)) {
        if($userdetails['position'] != "Administrator") {

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
    <link rel="stylesheet" href="./../css/admin.css">
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
                        <a href="scheduling.php" class="nav_link">
                            <img src="./../images/schedule.ico" class="nav_icon"></img>
                            <span class="nav_name">Scheduling</span>
                        </a>
                        <a href="#" class="nav_link">
                            <img src="./../images/database.ico" class="nav_icon"></img>
                            <span class="nav_name">Data Records</span>
                        </a>

                        <div class="nav_link collapse">
                            <img src="./../images/folder-2.ico" class="nav_icon"></img>
                            <span class="nav_name">Data Entry</span>
                            <img src="./../images/arrow-2.ico" class="collapse_link"></img>
                            <ul class="collapse_menu">
                                <a href="school_year.php" class="collapse_sublink">School&nbsp;Year</a>
                                <a href="course.php" class="collapse_sublink">Course</a>
                                <a href="subjects.php" class="collapse_sublink">Subjects</a>
                                <a href="sections.php" class="collapse_sublink">Sections</a>
                            </ul>
                        </div>
                        <div class="nav_link collapse">
                            <img src="./../images/teams.ico" class="nav_icon"></img>
                            <span class="nav_name">Teams</span>

                            <img src="./../images/arrow-2.ico" class="collapse_link"></img>
                            <ul class="collapse_menu">
                                <?php foreach($viewaccesses as $viewaccess) { ?>
                                    <a href="teams.php?position=<?=$viewaccess['access_name']; ?>" class="collapse_sublink"> <?= $viewaccess['access_name']; ?> </a>
                                <?php } ?> 
                            </ul>
                        </div>
                        <a href="fees.php" class="nav_link">
                            <img src="./../images/fees.ico" class="nav_icon"></img>
                            <span class="nav_name">Fees</span>
                        </a>
                    </div>
                </div>
                <a href="logout.php" class="nav_link">
                    <img src="./../images/logout.ico" class="nav_icon"></img>
                    <span class="nav_name">Logout</span>
                </a>
            </div>
        </div>
        <div class="right-side">
            <div class="main-container">
                <h1>Manage Course</h1>
                <button class="modal-btn">Add Course</button>
            </div>
                <form method = "POST" action = "<?php htmlspecialchars("PHP_SELF"); ?>">
                    <div class = "modal-bg">
                        <div class = "modal">
                            <h2>Adding Course</h2>
                            <label for="name">Course Code</label>
                            <input type = "text" name = "course_code" autocomplete="off">
                            <label for="name">Course Description</label>
                            <input type = "text" name = "course_desc" autocomplete="off">
                            <button class = "sub" name = "addcourse">Add Course</button>
                            <span class = "modal-close">X</span>
                        </div>
                    </div>
                </form>    
            <table class="table">
            <thead>
                <th>No.</th>
                <th>Course Code</th>
                <th>Course Description</th>
                <th>Option</th>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                <?php foreach($courses as $course) {?>
                <?php $i += 1; ?>
                <tr>        
                    <td data-label="No."><?php echo $i ?></td>
                    <td data-label="Course Code"><?=$course['course_code']; ?></td>
                    <td data-label="Course Description"><?=$course['course_description']; ?></td>        
                    <td data-label="Option">
                        <div class="opt_btn">
                            <form method="POST" action="editCourse.php">
                                <input type="submit" name="Edit" value="Edit">
                                <input type="hidden" name="editcourseCode" id="" value="<?=$course['course_code']; ?>">
                                <input type="hidden" name="editcourseDesc" id="" value="<?=$course['course_description']; ?>">
                            </form>
                            <form method="POST" action="deleteCourse.php">
                                <input type="submit" name="Delete" value="Delete">
                                <input type="hidden" name="deleteCourseCode" id="" value="<?=$course['course_code']; ?>">
                                <input type="hidden" name="deleteCourseDesc" id="" value="<?=$course['course_description']; ?>">
                            </form>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            </table>
        </div>
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modal.js"></script>
</body>
</html>