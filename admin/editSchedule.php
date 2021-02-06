<?php
    require_once('../enrollmentclass.php');
    
    $userdetails = $olenrollment->get_userdata();
    $viewaccesses = $olenrollment->getAccess();
    $teachers = $olenrollment->getTeachersName();
    $olenrollment->updateSchedule($_POST);

    if(isset($userdetails)) {
        if($userdetails['position'] != "Administrator") {

            header("Location: ../login.php");
        }
    } else {
        header("Location: ../login.php");
    }

    if(isset($_POST['Edit']))
    {
        $coursecode = $_POST['coursecode'];
        $term = $_POST['term'];
        $sectionid = $_POST['sectionid'];
        $id = $_POST['id'];
        $subject_code = $_POST['subject_code'];
        $subject_title = $_POST['subject_title'];
        $timefrom = $_POST['timefrom'];
        $timeto = $_POST['timeto'];
        $days = $_POST['days'];
        $a = explode(",",$days);
        $yearlevel = $_POST['yearlevel'];
        $section_name = $_POST['section_name'];
        $teacherid = $_POST['teacherid'];
        $deptname = $_POST['deptname'];
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
    <script>
    function editTeacherId(value) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else{
            xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange= function(){
            if (this.readyState==4 && this.status==200) {
                document.getElementById('teacherid').innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET","editTeacherId.php?value="+value, true);
        xmlhttp.send();
    }
    </script>
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
                <h2>Scheduling</h2>
            </div>
            <div class="side-container">
                <form method="POST" action = "<?php htmlspecialchars("PHP_SELF"); ?>">
                <h3>Subject Code (Read Only) </h3>
                <input type="hidden" name="id" id="" value="<?= $id ?>">
                <input type="hidden" name="course_code" id="" value="<?= $coursecode ?>">
                <input type="hidden" name="term" id="" value="<?= $term ?>">    
                <input type="hidden" name="yearlevel" id="" value="<?= $yearlevel ?>">
                <input type="hidden" name="sectionid" id="" value="<?= $sectionid ?>">
                <input type = "text" name = "" id="" value="<?= (isset($subject_code)) ? $subject_code : '';  ?>" autocomplete="off" readonly>
                <h3>Course Description (Read Only) </h3>
                <input type = "text" name = "" id="" value="<?= (isset($subject_title)) ? $subject_title : ''; ?>" autocomplete="off" readonly>
                <h3>Days</h3>
                <div class="checkbox-option">
                    <input type="checkbox" name="day[]" id="" class="chkOption" value="MON" <?= (in_array("MON", $a)) ? 'checked' : ''; ?>>MON
                    <input type="checkbox" name="day[]" id="" class="chkOption" value="TUE" <?= (in_array("TUE", $a)) ? 'checked' : ''; ?>>TUE
                    <input type="checkbox" name="day[]" id="" class="chkOption" value="WED" <?= (in_array("WED", $a)) ? 'checked' : ''; ?>>WED
                    <input type="checkbox" name="day[]" id="" class="chkOption" value="THU" <?= (in_array("THU", $a)) ? 'checked' : ''; ?>>THU
                    <input type="checkbox" name="day[]" id="" class="chkOption" value="FRI" <?= (in_array("FRI", $a)) ? 'checked' : ''; ?>>FRI
                    <input type="checkbox" name="day[]" id="" class="chkOption" value="SAT" <?= (in_array("SAT", $a)) ? 'checked' : ''; ?>>SAT
                </div>
                <h3>Time[From-To]</h3>
                <div class="edit-time-container">                    
                    <input type="time" name="timefrom" class="time-input" id=""  value="<?= (isset($timefrom)) ? $timefrom : ''; ?>" autocomplete="off">
                    <input type="time" name="timeto" class="time-input" id=""  value="<?= (isset($timeto)) ? $timeto : ''; ?>" autocomplete="off">                
                </div>
                <h3>Teacher ID </h3>
                <div id="teacherid">
                    <input type = "text" name = "teachersid" id="" value="<?= (isset($teacherid)) ? $teacherid : ''; ?>" autocomplete="off" readonly>
                </div>
                <h3>Teacher Name </h3>
                <select name="" id="" onchange="editTeacherId(this.value);">
                    <option disabled selected value> -- Select an option -- </option>
                    <?php foreach($teachers as $teacher) { ?>
                            <option value="<?= $teacher['deptname']; ?>" <?=  ($deptname==$teacher['deptname']) ? 'selected' : ''; ?>><?= $teacher['deptname']; ?> </option>
                    <?php } ?>
                </select>
                <h4>&nbsp;</h4>
                <?php if(isset($subject_code)) { ?>
                    <button type="submit" class="btn-update" name="Update">UPDATE</button>
                    <?php } else { ?>
                        <button type="submit" class="btn-update" name="update" disabled>UPDATE</button>
                    <?php } ?>
                </form>
                <div style="margin-top:1rem;"></div>                      
            </div>
        </div>
    <script src="../js/course.js"></script>
    <script src="../js/modalDept.js"></script>
</body>
</html>