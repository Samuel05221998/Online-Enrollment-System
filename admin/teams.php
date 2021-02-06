<?php
    require_once('../enrollmentclass.php');
    
    $position = " ";
     if(empty($_GET['position'])) {
        $position = null;
     } else {
         $position = $_GET['position'];
     }
    $getpositions = $olenrollment->get_position($position);
    $viewaccesses = $olenrollment->getAccess();
    $userdetails = $olenrollment->get_userdata();
    $olenrollment->addDepartment($_POST);
    $programs = $olenrollment->getCourse_Code();

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
                <h1>Manage <?= $position ?></h1>
                <button class="team-modal-btn" <?= (is_array($getpositions) || is_object($getpositions))  ? $position : 'disabled';?>>Add <?= $position ?></button>
            </div>
                <form method = "POST" action = "<?php htmlspecialchars("PHP_SELF"); ?>">
                    <div class = "team-modal-bg">
                        <div class = "team-modal">
                            <h2>Adding <?= $position ?></h2>
                            <h6>&nbsp;</h6>
                            <div class="team-row">
                                <label>Department ID : </label>
                                <input type = "text" name = "dept_id" autocomplete="off">
                            </div>
                            <div class="team-row">
                                <label>Last Name : </label>
                                <input type = "text" name = "last_name" autocomplete="off">
                            </div>
                            <div class="team-row">
                                <label>First Name : </label>
                                <input type = "text" name = "first_name" autocomplete="off">
                            </div>
                            <div class="team-row">
                                <label>Middle Name : </label>
                                <input type = "text" name = "middle_name" autocomplete="off">
                            </div>
                            <div class="team-row">
                                <label>Department Course : </label>
                                <select name="dept_course" id="">
                                    <option  disabled selected value> -- Select an option -- </option>
                                    <?php foreach($programs as $program) { ?>
                                    <option value = "<?= $program['course_code']; ?>"> <?= $program['course_code']; ?> </option>
                                    <?php } ?>
                                    <option value="None">None</option>
                                </select>
                            </div>
                            <div class="team-row">
                                <label> Email : </label>
                                <input type = "email" name = "email" autocomplete="off">
                            </div>
                            <div class="team-row">
                                <label> Under Graduate : </label>
                                <input type = "text" name = "under_graduate" autocomplete="off">
                            </div>
                            <div class="team-row">
                                <label> Graduate : </label>
                                <input type = "text" name = "graduate" autocomplete="off">
                            </div>
                            <div class="team-row">
                                <label>Password : </label>
                                <input type = "text" name = "password" autocomplete="off">
                            </div>
                            
                            <div class="team-row">
                                <label> Position : (Read Only) </label>
                                <input type = "text" name = "position" value="<?= $position ?>" autocomplete="off" readonly>
                            </div>
                            <h3>&nbsp;</h3> 
                            <div class="team-button-form">
                            <button class = "sub" name = "save">Save <?= $position ?></button>
                            </div>
                            <span class = "team-modal-close">X</span>
                        </div>
                    </div>
                </form>    
            <table class="table">
            <thead>
                <th>Department ID</th>
                <th>Full Name</th>
                <th>Department Course</th>
                <th>Email</th>
                <th>Under Graduate</th>
                <th>Graduate</th>
                <th>Username</th>
                <th>Password</th>
                <th>Position</th>
                <th>Option</th>
            </thead>
            <tbody>
                <?php if(is_array($getpositions) || is_object($getpositions))  {?>
                <?php foreach($getpositions as $getposition) {?>
                    <tr>
                        <td data-label="Username"><?= $getposition['dept_id']; ?></td>
                        <td data-label="Full Name"> <?= $getposition['first_name']; ?> <?= $getposition['middle_name'];?> <?= $getposition['last_name'];?></td>  
                        <td data-label="Password"><?= $getposition['dept_course']; ?></td>
                        <td data-label="Password"><?= $getposition['email']; ?></td>
                        <td data-label="Password"><?= $getposition['under_graduate']; ?></td>
                        <td data-label="Email"><?= $getposition['graduate']; ?></td>
                        <td data-label="Access"><?= $getposition['username']; ?></td>
                        <td data-label="Access"><?= $getposition['password']; ?></td>
                        <td data-label="Username"><?= $getposition['position']; ?></td>
                        <td data-label="Option">
                            <div class="opt_btn">
                                <form action="editTeam.php?position=<?=$getposition['position']; ?>" method="POST">
                                    <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                    <input type="hidden" name="dept_id" value="<?= $getposition['dept_id'];?>">
                                    <input type="hidden" name="last_name" value="<?= $getposition['last_name'];?>">
                                    <input type="hidden" name="first_name" value="<?= $getposition['first_name'];?>">
                                    <input type="hidden" name="middle_name" value="<?= $getposition['middle_name'];?>">
                                    <input type="hidden" name="dept_course" value="<?= $getposition['dept_course'];?>">
                                    <input type="hidden" name="email" value="<?= $getposition['email'];?>">
                                    <input type="hidden" name="under_graduate" value="<?= $getposition['under_graduate'];?>">
                                    <input type="hidden" name="graduate" value="<?= $getposition['graduate'];?>">
                                    <input type="hidden" name="username" value="<?= $getposition['username'];?>">
                                    <input type="hidden" name="password" value="<?= $getposition['password'];?>">
                                    <input type="hidden" name="position" value="<?= $getposition['position'];?>">
                                </form>
                                <form method="POST" action="deleteTeam.php?position=<?=$getposition['position']; ?>">
                                    <input type="submit" class="btn-submit" name="Delete" value="DELETE">
                                    <input type="hidden" name="dept_id" value="<?= $getposition['dept_id'];?>">
                                    <input type="hidden" name="last_name" value="<?= $getposition['last_name'];?>">
                                    <input type="hidden" name="first_name" value="<?= $getposition['first_name'];?>">
                                    <input type="hidden" name="middle_name" value="<?= $getposition['middle_name'];?>">
                                    <input type="hidden" name="dept_course" value="<?= $getposition['dept_course'];?>">
                                    <input type="hidden" name="email" value="<?= $getposition['email'];?>">
                                    <input type="hidden" name="under_graduate" value="<?= $getposition['under_graduate'];?>">
                                    <input type="hidden" name="graduate" value="<?= $getposition['graduate'];?>">
                                    <input type="hidden" name="username" value="<?= $getposition['username'];?>">
                                    <input type="hidden" name="password" value="<?= $getposition['password'];?>">
                                    <input type="hidden" name="position" value="<?= $getposition['position'];?>">
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <?php }  else { echo "No Data"; }?>
            </tbody>
            </table>
        </div>
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modalDept.js"></script>
</body>
</html>