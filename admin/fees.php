<?php
    require_once('../enrollmentclass.php');

    $scourse = " ";
    if(empty($_GET['course'])) {
        $scourse = null;
    } else {
        $scourse = $_GET['course'];
    }

    $yearlevel = " ";
    if(empty($_GET['yearlevel'])) {
        $yearlevel = null;
    } else {
        $yearlevel = $_GET['yearlevel'];
    }

    $term = " ";
    if(empty($_GET['term'])) {
        $scourse = null;
    } else {
        $term = $_GET['term'];
    }
    
    // $id = $_GET['id'];
    $selectcourses = $olenrollment->getCourse();
    $userdetails = $olenrollment->get_userdata();
    $viewaccesses = $olenrollment->getAccess();
    $courses = $olenrollment->getCourse();
    $olenrollment->addFee($_POST);
    $viewfees = $olenrollment->viewFee($yearlevel,$term,$scourse);

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
    <script>
	function show_confirm()
        {
        var r = confirm("Are you sure to restore this row?");
        if(r == true)
        {
            <?= $olenrollment->deleteFees($_POST); ?>
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
                <h2>Manage fees</h2>
                <button class="modal-btn">Add Fees</button>
            </div>
            <form method = "POST" action = "<?php htmlspecialchars("PHP_SELF"); ?>">
                <div class = "modal-bg">
                    <div class = "modal">
                        <h2>Adding Fees</h2>
                        <label>Course :</label>
                        <select name="course" id="SelectA">
                            <option disabled selected value> -- Select an option -- </option>
                            <?php foreach($selectcourses as $selectcourse) { ?>
                                    <option value="<?= $selectcourse['course_code']; ?>" ><?= $selectcourse['course_code']; ?> </option>
                            <?php } ?>
                        </select>
                        <label for="name">Year Level</label>
                        <select name="yearlevel" id="">
                            <option disabled selected value> -- Select an option -- </option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                        <label for="name">Term</label> 
                        <select name="term" id="">
                            <option disabled selected value> -- Select an option -- </option>
                            <option value="1st Term">1st Term</option>
                            <option value="2nd Term">2nd Term</option>
                        </select>
                        <label for="name">Description</label>
                        <input type = "text" name = "description" autocomplete="off">
                        <label for="name">Amount</label>
                        <input type = "text" name = "amount" autocomplete="off">
                       <button class = "sub" name = "Save">Save Fee</button>
                        <span class = "modal-close">X</span>
                    </div>
                </div>
            </form>
            <div class="select-option">
                    <form method="GET" action="fees.php?course=<?= $scourse ?>yearlevel=<?=  $yearlevel ?>term=<?= $term ?>">
                        <label>Course :</label>
                        <select name="course" id="SelectA">
                            <option disabled selected value> -- Select an option -- </option>
                            <?php foreach($selectcourses as $selectcourse) { ?>
                                    <option value="<?= $selectcourse['course_code']; ?>" <?= ($scourse==$selectcourse['course_code']) ? 'selected' : ''; ?>><?= $selectcourse['course_code']; ?> </option>
                            <?php } ?>
                        </select>
                        <label>Year Level :</label> 
                        <select name="yearlevel" id="">
                            <option disabled selected value> -- Select an option -- </option>
                            <option value="1st Year" <?= ($yearlevel=="1st Year") ? 'selected' : ' '; ?>>1st Year</option>
                            <option value="2nd Year" <?= ($yearlevel=="2nd Year") ? 'selected' : ' '; ?>>2nd Year</option>
                            <option value="3rd Year" <?= ($yearlevel=="3rd Year") ? 'selected' : ' '; ?>>3rd Year</option>
                            <option value="4th Year" <?= ($yearlevel=="4th Year") ? 'selected' : ' '; ?>>4th Year</option>
                        </select>
                        <label>Term :</label> 
                        <select name="term" id="">
                            <option disabled selected value> -- Select an option -- </option>
                            <option value="1st Term" <?= ($term=="1st Term") ? 'selected' : ' '; ?>>1st Term</option>
                            <option value="2nd Term" <?= ($term=="2nd Term") ? 'selected' : ' '; ?>>2nd Term</option>
                        </select>
                        <input type="submit" class="button-select" value = "Load Data">
                    </form>
                </div>
            <table class="table">
                <thead>
                    <th>No.</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Option</th>
                </thead>
                <tbody>
                <?php $i = 0; ?>
                <?php $totalAmount = 0; ?>
                <?php if(is_array($viewfees) || is_object($viewfees))  {?>
                <?php foreach($viewfees as $viewfee) {?>
                    <?php $i += 1; ?>       
                    <tr>
                    <td data-label="No."><?php echo $i ?></td>
                    <td><?= $viewfee['description']; ?></td>
                    <td><?= $viewfee['amount']; ?></td>
                    <td>
                        <div class="opt_btn">
                            <form action="editFees.php" method="POST">
                                <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                <input type="hidden" name="id" id="" value="<?= $viewfee['fid']; ?>">
                                <input type="hidden" name="coursecode" id="" value="<?= $viewfee['course_code']; ?>">
                                <input type="hidden" name="yearlevel" id="" value="<?= $viewfee['yearlevel']; ?>">
                                <input type="hidden" name="term" id="" value="<?= $viewfee['term']; ?>">
                                <input type="hidden" name="description" id="" value="<?= $viewfee['description']; ?>">
                                <input type="hidden" name="amount" id="" value="<?= $viewfee['amount']; ?>">
                            </form>
                            <form action="<?php htmlspecialchars("PHP_SELF"); ?>" method="POST">
                                <input type="submit" class="btn-submit" name="delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $viewfee['description']; ?> ?');">
                                <input type="hidden" name="id" id="" value="<?= $viewfee['fid']; ?>">
                                <input type="hidden" name="coursecode" id="" value="<?= $viewfee['course_code']; ?>">
                                <input type="hidden" name="yearlevel" id="" value="<?= $viewfee['yearlevel']; ?>">
                                <input type="hidden" name="term" id="" value="<?= $viewfee['term']; ?>">
                            </form>
                        </div>
                    </td>
                    </tr>
                    <?php $totalAmount += $viewfee['amount']  ?> 
                <?php } ?>
                <?php } else { echo "No Data"; }?>   
                    <tr>
                    <td colspan=2>Total Amount</td>
                    <td><?= number_format($totalAmount, 2); ?></td>
                    <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modal.js"></script>
</body>
</html>