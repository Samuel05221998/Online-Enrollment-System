<?php
    require_once('../enrollmentclass.php');
    
    $userdetails = $olenrollment->get_userdata();
    $viewaccesses = $olenrollment->getAccess();
    $olenrollment->updateFees($_POST);

    if(isset($userdetails)) {
        if($userdetails['position'] != "Administrator") {

            header("Location: ../login.php");
        }
    } else {
        header("Location: ../login.php");
    }

    if(isset($_POST['Edit']))
    {
        $id = $_POST['id'];
        $coursecode = $_POST['coursecode'];
        $yearlevel = $_POST['yearlevel'];
        $term = $_POST['term'];
        $description = $_POST['description'];
        $amount = $_POST['amount'];
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
                        <div class="nav_link collapse">
                            <img src="./../images/schedule.ico" class="nav_icon"></img>
                            <span class="nav_name">Scheduling</span>
                            <img src="./../images/arrow-2.ico" class="collapse_link"></img>
                            <ul class="collapse_menu">
                                <a href="scheduling.php" class="collapse_sublink">Add&nbsp;Schedule</a>
                                <a href="scheduling.php" class="collapse_sublink">List&nbsp;of&nbsp;Schedule</a>
                            </ul>
                        </div>
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
                <h1>Manage Fees</h1>
            </div>
            <div class="side-container">
                <form method="POST" action = "<?php htmlspecialchars("PHP_SELF"); ?>">
                <input type = "hidden" name = "id" id="" value="<?= (isset($id)) ? $id : '';  ?>" autocomplete="off">
                <h3>Year Level (Read Only)</h3>
                <input type = "text" name = "yearlevel" id="" value="<?= (isset($yearlevel)) ? $yearlevel : '';  ?>" autocomplete="off" readonly>
                <h3>Term (Read Only)</h3>
                <input type = "text" name = "term" id="" value="<?= (isset($term)) ? $term : '';  ?>" autocomplete="off" readonly>
                <h3>Course Code (Read Only)</h3>
                <input type = "text" name = "coursecode" id="" value="<?= (isset($coursecode)) ? $coursecode : '';  ?>" autocomplete="off" readonly>
                <h3>Description</h3>
                <input type = "text" name = "description" id="" value="<?= (isset($description)) ? $description : '';  ?>" autocomplete="off">
                <h3>Amount</h3>
                <input type = "text" name = "amount" id="" value="<?= (isset($amount)) ? $amount : ''; ?>" autocomplete="off">
                <h4>&nbsp;</h4>
                <?php if(isset($coursecode)) { ?>
                    <button type="submit" class="btn-update" name="update">UPDATE</button>
                    <div style="margin-top:50px;"></div>
                    <?php } else { ?>
                        <button type="submit" class="btn-update" name="update" disabled>UPDATE</button>
                        <div style="margin-top:50px;"></div>
                        <?php } ?>
                </form>                      
            </div>
        </div>
    </div>
    <script src="../js/course.js"></script>
</body>
</html>