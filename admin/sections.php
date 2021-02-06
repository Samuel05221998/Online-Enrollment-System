<?php
 require_once('../enrollmentclass.php');

 $scourse = " ";
 if(empty($_GET['course'])) {
     $scourse = null;
 } else {
     $scourse = $_GET['course'];
 }
    
 // $id = $_GET['id'];
 $userdetails = $olenrollment->get_userdata();
 $viewaccesses = $olenrollment->getAccess();
 $courses = $olenrollment->getCourse();
 $olenrollment->addSection($_POST);
 $sections = $olenrollment->getSection();
 $firstsec1sts = $olenrollment->get1stSec1st($scourse);
 $firstsec2nds = $olenrollment->get1stSec2nd($scourse);
 $secondsec1sts = $olenrollment->get2ndSec1st($scourse);
 $secondsec2nds = $olenrollment->get2ndSec2nd($scourse);
 $thirdsec1sts = $olenrollment->get3rdSec1st($scourse);
 $thirdsec2nds = $olenrollment->get3rdSec2nd($scourse);
 $fourthsec1sts = $olenrollment->get4thSec1st($scourse);
 $fourthsec2nds = $olenrollment->get4thSec2nd($scourse);

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
    <script>
	function show_confirm()
        {
        var r = confirm("Are you sure to restore this row?");
        if(r == true)
        {
            <?= $olenrollment->deleteSection($_POST); ?>
            return true;
        } else {
            return false;
        }
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
                <h1>Manage Sections</h1>
                <button class="modal-btn">Add Section</button>
            </div>
            <form method = "POST" action = "<?php htmlspecialchars("PHP_SELF"); ?>">
                <div class = "modal-bg">
                    <div class = "modal">
                        <h2>Adding Section</h2>
                        <label for="name">Course</label>
                        <select name="course_code" id="">
                            <option disabled selected value> -- Select an option -- </option>
                            <?php foreach($courses as $course) { ?>
                            <option value="<?= $course['course_code'] ?>"><?= $course['course_code'] ?></option>
                            <?php } ?>
                        </select> 
                        <label for="name">Section ID</label>
                        <input type = "text" name = "section_id" autocomplete="off">
                        <label for="name">Section Name</label>
                        <input type="text" name="section_name" autocomplete="off">
                        <label for="name">Year Level</label>
                        <select name="yearlevel" id="">
                            <option disabled selected value> -- Select an option -- </option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                        <label>Term</label>
                        <select name="term" id="">
                            <option disabled selected value> -- Select an option -- </option>
                            <option value="1st Term">1st Term</option>
                            <option value="2nd Term">2nd Term</option>
                        </select> 
                        </select>    
                        <button class = "sub" name = "add_section">Add Section</button>
                        <span class = "modal-close">X</span>
                    </div>
                </div>
            </form>
            <div class="select-option">
                <form method="GET" action="sections.php">
                <label>Course : </label>
                    <select name="course" id="">
                        <option disabled selected value> -- Select an option -- </option>
                        <?php foreach($courses as $course) { ?>
                        <option value="<?= $course['course_code'] ?>"><?= $course['course_code'] ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" class="button-select" value = "Load Data">
                </form>
            </div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Section ID</th>
                        <th>First Year, First Term</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                    <?php if(is_array($firstsec1sts) || is_object($firstsec1sts))  {?>
                        <?php foreach($firstsec1sts as $firstsec1st) {?>
                        <tr>        
                            <td data-label="Section ID"><?=$firstsec1st['section_id']; ?></td>
                            <td data-label="Section Name"><?=$firstsec1st['section_name']; ?></td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form method="POST" action="editSection.php">
                                        <input type="submit" name="Edit" value="Edit">
                                        <input type="hidden" name="sectionid" value="<?=$firstsec1st['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$firstsec1st['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$firstsec1st['course_code']; ?>">
                                        <input type="hidden" name="yearlevel" value="<?=$firstsec1st['yearlevel']; ?>">
                                        <input type="hidden" name="term" value="<?= $firstsec1st['term']; ?>">
                                    </form>
                                    <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $firstsec1st['section_name']; ?> ?');">
                                        <input type="hidden" name="sectionid" value="<?=$firstsec1st['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$firstsec1st['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$firstsec1st['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } else  { echo " "; } ?>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Section ID</th>
                        <th>First Year, Second Term</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        <?php if(is_array($firstsec2nds) || is_object($firstsec2nds))  {?>
                        <?php foreach($firstsec2nds as $firstsec2nd) {?>
                        <tr>        
                            <td data-label="Section ID"><?=$firstsec2nd['section_id']; ?></td>
                            <td data-label="Section Name"><?=$firstsec2nd['section_name']; ?></td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form method="POST" action="editSection.php">
                                        <input type="submit" name="Edit" value="Edit">
                                        <input type="hidden" name="sectionid" value="<?=$firstsec2nd['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$firstsec2nd['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$firstsec2nd['course_code']; ?>">
                                        <input type="hidden" name="yearlevel" value="<?=$firstsec2nd['yearlevel']; ?>">
                                        <input type="hidden" name="term" value="<?= $firstsec2nd['term']; ?>">
                                    </form>
                                    <form method="POST" action="deleteSection.php">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $firstsec2nd['section_name']; ?> ?');">
                                        <input type="hidden" name="sectionid" value="<?=$firstsec2nd['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$firstsec2nd['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$firstsec2nd['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } else  { echo " "; } ?>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Section ID</th>
                        <th>Second Year, 1st Term</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        <?php if(is_array($secondsec1sts) || is_object($secondsec1sts))  {?>
                        <?php foreach($secondsec1sts as $secondsec1st) {?>
                        <tr>        
                            <td data-label="Section ID"><?=$secondsec1st['section_id']; ?></td>
                            <td data-label="Section Name"><?=$secondsec1st['section_name']; ?></td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form method="POST" action="editSection.php">
                                        <input type="submit" name="Edit" value="Edit">
                                        <input type="hidden" name="sectionid" value="<?=$secondsec1st['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$secondsec1st['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$secondsec1st['course_code']; ?>">
                                        <input type="hidden" name="yearlevel" value="<?=$secondsec1st['yearlevel']; ?>">
                                        <input type="hidden" name="term" value="<?= $secondsec1st['term']; ?>">
                                    </form>
                                    <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $secondsec1st['section_name']; ?> ?');">
                                        <input type="hidden" name="sectionid" value="<?=$secondsec1st['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$secondsec1st['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$secondsec1st['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } else  { echo " "; } ?>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Section ID</th>
                        <th>Second Year, Second Term</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        <?php if(is_array($secondsec2nds) || is_object($secondsec2nds))  {?>
                        <?php foreach($secondsec2nds as $secondsec2nd) {?>
                        <tr>        
                            <td data-label="Section ID"><?=$secondsec2nd['section_id']; ?></td>
                            <td data-label="Section Name"><?=$secondsec2nd['section_name']; ?></td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form method="POST" action="editSection.php">
                                        <input type="submit" name="Edit" value="Edit">
                                        <input type="hidden" name="sectionid" value="<?=$secondsec2nd['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$secondsec2nd['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$secondsec2nd['course_code']; ?>">
                                        <input type="hidden" name="yearlevel" value="<?=$secondsec2nd['yearlevel']; ?>">
                                        <input type="hidden" name="term" value="<?= $secondsec2nd['term']; ?>">
                                    </form>
                                    <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $secondsec2nd['section_name']; ?> ?');">
                                        <input type="hidden" name="sectionid" value="<?=$secondsec2nd['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$secondsec2nd['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$secondsec2nd['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } else  { echo " "; } ?>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Section ID</th>
                        <th>Third Year, First Term</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        <?php if(is_array($thirdsec1sts) || is_object($thirdsec1sts))  {?>
                        <?php foreach($thirdsec1sts as $thirdsec1st) {?>
                        <tr>        
                            <td data-label="Section ID"><?=$thirdsec1st['section_id']; ?></td>
                            <td data-label="Section Name"><?=$thirdsec1st['section_name']; ?></td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form method="POST" action="editSection.php">
                                        <input type="submit" name="Edit" value="Edit">
                                        <input type="hidden" name="sectionid" value="<?=$thirdsec1st['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$thirdsec1st['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$thirdsec1st['course_code']; ?>">
                                        <input type="hidden" name="yearlevel" value="<?=$thirdsec1st['yearlevel']; ?>">
                                        <input type="hidden" name="term" value="<?= $thirdsec1st['term']; ?>">
                                    </form>
                                    <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $thirdsec1st['section_name']; ?> ?');">
                                        <input type="hidden" name="sectionid" value="<?=$thirdsec1st['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$thirdsec1st['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$thirdsec1st['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } else  { echo " "; } ?>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Section ID</th>
                        <th>Third Year, Second Term</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        <?php if(is_array($thirdsec2nds) || is_object($thirdsec2nds))  {?>
                        <?php foreach($thirdsec2nds as $thirdsec2nd) {?>
                        <tr>        
                            <td data-label="Section ID"><?=$thirdsec2nd['section_id']; ?></td>
                            <td data-label="Section Name"><?=$thirdsec2nd['section_name']; ?></td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form method="POST" action="editSection.php">
                                        <input type="submit" name="Edit" value="Edit">
                                        <input type="hidden" name="sectionid" value="<?=$thirdsec2nd['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$thirdsec2nd['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$thirdsec2nd['course_code']; ?>">
                                        <input type="hidden" name="yearlevel" value="<?=$thirdsec2nd['yearlevel']; ?>">
                                        <input type="hidden" name="term" value="<?= $thirdsec2nd['term']; ?>">
                                    </form>
                                    <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $thirdsec2nd['section_name']; ?> ?');">
                                        <input type="hidden" name="sectionid" value="<?=$thirdsec2nd['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$thirdsec2nd['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$thirdsec2nd['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } else  { echo " "; } ?>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Section ID</th>
                        <th>Fourth Year, First Term</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        <?php if(is_array($fourthsec1sts) || is_object($fourthsec1sts))  {?>
                        <?php foreach($fourthsec1sts as $fourthsec1st) {?>
                        <tr>        
                            <td data-label="Section ID"><?=$fourthsec1st['section_id']; ?></td>
                            <td data-label="Section Name"><?=$fourthsec1st['section_name']; ?></td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form method="POST" action="editSection.php">
                                        <input type="submit" name="Edit" value="Edit">
                                        <input type="hidden" name="sectionid" value="<?=$fourthsec1st['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$fourthsec1st['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$fourthsec1st['course_code']; ?>">
                                        <input type="hidden" name="yearlevel" value="<?=$fourthsec1st['yearlevel']; ?>">
                                        <input type="hidden" name="term" value="<?= $fourthsec1st['term']; ?>">
                                    </form>
                                    <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $fourthsec1st['section_name']; ?> ?');">
                                        <input type="hidden" name="sectionid" value="<?=$fourthsec1st['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$fourthsec1st['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$fourthsec1st['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } else  { echo " "; } ?>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Section ID</th>
                        <th>Fourth Year, Second Term</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        <?php if(is_array($fourthsec2nds) || is_object($fourthsec2nds))  {?>
                        <?php foreach($fourthsec2nds as $fourthsec2nd) {?>
                        <tr>        
                            <td data-label="Section ID"><?=$fourthsec2nd['section_id']; ?></td>
                            <td data-label="Section Name"><?=$fourthsec2nd['section_name']; ?></td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form method="POST" action="editSection.php">
                                        <input type="submit" name="Edit" value="Edit">
                                        <input type="hidden" name="sectionid" value="<?=$fourthsec2nd['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$fourthsec2nd['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$fourthsec2nd['course_code']; ?>">
                                        <input type="hidden" name="yearlevel" value="<?=$fourthsec2nd['yearlevel']; ?>">
                                        <input type="hidden" name="term" value="<?= $fourthsec2nd['term']; ?>">
                                    </form>
                                    <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $fourthsec2nd['section_name']; ?> ?');">
                                        <input type="hidden" name="sectionid" value="<?=$fourthsec2nd['section_id']; ?>">
                                        <input type="hidden" name="sectionname" value="<?=$fourthsec2nd['section_name']; ?>">
                                        <input type="hidden" name="coursecode" value="<?=$fourthsec2nd['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } else  { echo " "; } ?>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
        </div>
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modal.js"></script>
</body>
</html>
            