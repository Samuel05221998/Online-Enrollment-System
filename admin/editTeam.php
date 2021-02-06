<?php
    require_once('../enrollmentclass.php');

    $access = $_GET['position'];
    $userdetails = $olenrollment->get_userdata();
    $olenrollment->updateDept($_POST);
    $programs = $olenrollment->getCourse_Code();

    if(isset($userdetails)) {
        if($userdetails['position'] != "Administrator") {

            header("Location: ../login.php");
        }
    } else {
        header("Location: ../login.php");
    }

    if(isset($_POST['Edit'])) {
        $dept_id = $_POST['dept_id'];
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $dept_course = $_POST['dept_course'];
        $email = $_POST['email'];
        $under_graduate = $_POST['under_graduate'];
        $graduate = $_POST['graduate'];
        $username = $_POST['username'];
        $graduate = $_POST['graduate'];
        $password = $_POST['password'];
        $position = $_POST['position'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <title>Document</title>
    <link rel="stylesheet" href="../css/admin.css">
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
                                <a href="school_year.php" class="collapse_sublink">School_Year</a>
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
                                    <a href="teams.php?access=<?=$viewaccess['access_name']; ?>" class="collapse_sublink"> <?= $viewaccess['access_name']; ?> </a>
                                <?php } ?> 
                            </ul>
                        </div>
                        <a href="#" class="nav_link">
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
                <h1>Manage <?= $access ?></h1>
            </div>    
            <div class="side-container">
                <form method="POST">
                    <h2>Updating <?= $access ?></h2>
                        <h6>&nbsp;</h6>
                        <h3>Department ID </h3>
                        <input type = "text" name = "dept_id" id="last_name" value="<?= $dept_id ?>" autocomplete="off" readonly>
                        <h3>Last Name </h3>
                        <input type = "text" name = "last_name" id="last_name" value="<?= $last_name ?>" autocomplete="off">
                        <h3>First Name </h3>
                        <input type = "text" name = "first_name" id="first_name" value="<?= $first_name ?>" autocomplete="off">
                        <h3>Middle Name </h3>
                        <input type = "text" name = "middle_name" id="last_name" value="<?= $middle_name ?>" autocomplete="off">
                        <h3>Department Course</h3>
                        <select name = "dept_course" id="SelectA">
                            <option  disabled selected value> -- Select an option -- </option>
                            <?php foreach($programs as $program) { ?>
                                <option value = "<?= $program['course_code']; ?>"<?=  ($dept_course==$program['course_code']) ? 'selected' : ''; ?>> <?= $program['course_code'] ?> </option>
                            <?php } ?>
                        </select>
                        <h3> Email  </h3>
                        <input type = "email" name = "email" id="email" value="<?= $email ?>" autocomplete="off">
                        <h3> Under Gradute  </h3>
                        <input type = "text" name = "under_graduate" id="email" value="<?= $under_graduate ?>" autocomplete="off">
                        <h3> Graduate  </h3>
                        <input type = "text" name = "graduate" id="email" value="<?= $graduate ?>" autocomplete="off">
                        <h3>Username </h3>
                        <input type = "text" name = "username" id="username" value="<?= $username ?>" autocomplete="off">
                        <h3>Password  </h3>
                        <input type = "text" name = "password" id="password" value="<?= $password ?>" autocomplete="off">	
                        <h3> Position  </h3>
                        <input type = "text" name = "position" id="password" value="<?= $position ?>" autocomplete="off" readonly>
                        <h3>&nbsp;</h3>
                        <button type="submit" class="btn-update" name="update">UPDATE</button>
                        <div style="margin-top: 50px"></div>
                        <input type="hidden" name="updateId" value="<?php echo $editId ?>" /> 
                </form> 
            </div>
        </div>
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modal.js"></script>
</body>
</html>