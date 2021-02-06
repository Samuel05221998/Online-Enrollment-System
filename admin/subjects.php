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
 $programs = $olenrollment->getCourse_Code();
 $courses = $olenrollment->getCourse();
 $olenrollment->addSubject($_POST);
 $firstyear1sts = $olenrollment->get1stYear1stTermSubject($scourse);
 $firstyear2nds = $olenrollment->get1stYear2ndTermSubject($scourse);
 $secondyear1sts = $olenrollment->get2ndYear1stTermSubject($scourse);
 $secondyear2nds = $olenrollment->get2ndYear2ndTermSubject($scourse);
 $thirdyear1sts = $olenrollment->get3rdYear1stTermSubject($scourse);
 $thirdyear2nds = $olenrollment->get3rdYear2ndTermSubject($scourse);
 $fourthyear1sts = $olenrollment->get4thYear1stTermSubject($scourse);
 $fourthyear2nds = $olenrollment->get4thYear2ndTermSubject($scourse);

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
            <?= $olenrollment->deleteSubject($_POST); ?>
            return true;
        } else {
            return false;
        }
    }


// function my_fun(str) {

// 	if (window.XMLHttpRequest) {
// 		xmlhttp = new XMLHttpRequest();
// 	} else{
// 		xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
// 	}

// 	xmlhttp.onreadystatechange= function(){
// 		if (this.readyState==4 && this.status==200) {
// 			document.getElementById('poll').innerHTML = this.responseText;
// 		}
// 	}
// 	xmlhttp.open("GET","helper.php?value="+str, true);
// 	xmlhttp.send();

// }
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
                <h1>Manage Subjects</h1>
                <button class="modal-btn">Add Subject</button>
            </div>
            <form method = "POST" action = "<?php htmlspecialchars("PHP_SELF"); ?>">
                <div class = "modal-bg">
                    <div class = "modal">
                        <h2>Adding Subject</h2>
                        <label for="name">Course</label>
                        <select name="course" id="">
                            <option disabled selected value> -- Select an option -- </option>
                            <?php foreach($courses as $course) { ?>
                            <option value="<?= $course['course_code'] ?>"><?= $course['course_code'] ?></option>
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
                        <label for="name">Subject Code</label>
                        <input type = "text" name = "subject_code" autocomplete="off">
                        <label for="name">Subject Title</label>
                        <input type = "text" name = "subject_title" autocomplete="off">
                        <label for="name">Units</label>
                        <input type="number" name="units" min="1" value="3">  
                        <label for="name">Price</label>
                        <input type = "text" name = "price" autocomplete="off">                     
                        <button class = "sub" name = "addsubject">Add Subject</button>
                        <span class = "modal-close">X</span>
                    </div>
                </div>
            </form>
            <div class="select-option">
                <form method="GET" action="subjects.php">
                <label>Course : </label>
                    <select name="course" id="loadcourse_code" onchange="LoadSectionName();">
                        <option disabled selected value> -- Select an option -- </option>
                        <?php foreach($courses as $course) { ?>
                        <option value="<?= $course['course_code'] ?>" <?= ($course['course_code']==$scourse) ? 'selected' : ' ' ?>><?= $course['course_code'] ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" class="button-select" value = "Load Data">
                </form>
            </div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Subject Code</th>
                        <th>First Year, First Term</th>
                        <th>Units</th>
                        <th>Price</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                        <?php $sum = 0; ?>
                        <?php $totalAmount = 0; ?>
                        <?php foreach($firstyear1sts as $firstyear1st) {?>
                        <tr>
                            <td data-label="Subject Code"> <?= $firstyear1st['subject_code']; ?> </td>
                            <td data-label="Subject Title"> <?= $firstyear1st['subject_title']; ?> </td>
                            <td data-label="Units"> <?= $firstyear1st['units']; ?> </td>
                            <td data-label="price"> <?= $firstyear1st['price']; ?> </td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form action="editSubject.php" method="POST">
                                    <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                    <input type="hidden" name="yearlevel" value="<?= $firstyear1st['yearlevel'] ?>">
                                    <input type="hidden" name="term" value="<?= $firstyear1st['term'] ?>">
                                    <input type="hidden" name="subjectcode" value="<?= $firstyear1st['subject_code']; ?>">
                                    <input type="hidden" name="subjecttitle" value="<?= $firstyear1st['subject_title']; ?>">
                                    <input type="hidden" name="units" value="<?= $firstyear1st['units']; ?>">
                                    <input type="hidden" name="id" value="<?= $firstyear1st['id']; ?>">
                                    <input type="hidden" name="coursecode" value="<?= $firstyear1st['course_code']; ?>">
                                    <input type="hidden" name="price" value="<?= $firstyear1st['price']; ?>">
                                    </form>
                                    <form action="<?php htmlspecialchars("PHP_SELF"); ?>" method="POST">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $firstyear1st['subject_title']; ?> ?');">
                                        <input type="hidden" name="id" value="<?= $firstyear1st['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $firstyear1st['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php $sum += $firstyear1st['units']  ?>
                        <?php $totalAmount += $firstyear1st['amount']  ?>
                        <?php } ?>
                        <tr>
                        <td colspan="2">Total Units</td>
                        <td><?= $sum; ?></td>
                        <td>Total Amount : <?= number_format($totalAmount,2); ?></td>
                        <td></td>
                        </tr>
                    </tbody>
                    
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Subject Code</th>
                        <th>First Year, Second Term</th>
                        <th>Units</th>
                        <th>Price</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                    <?php $sum = 0; ?>
                    <?php $totalAmount = 0; ?>
                        <?php foreach($firstyear2nds as $firstyear2nd) {?>
                        <tr>
                            <td data-label="Subject Code"> <?= $firstyear2nd['subject_code']; ?> </td>
                            <td data-label="Subject Title"> <?= $firstyear2nd['subject_title']; ?> </td>
                            <td data-label="Units"> <?= $firstyear2nd['units']; ?> </td>
                            <td data-label="Units"> <?= $firstyear2nd['price']; ?> </td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form action="editSubject.php" method="POST">
                                        <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                        <input type="hidden" name="yearlevel" value="<?= $firstyear2nd['yearlevel']     ?>">
                                        <input type="hidden" name="term" value="<?= $firstyear2nd['term'] ?>">
                                        <input type="hidden" name="subjectcode" value="<?= $firstyear2nd    ['subject_code']; ?>">
                                        <input type="hidden" name="subjecttitle" value="<?= $firstyear2nd   ['subject_title']; ?>">
                                        <input type="hidden" name="units" value="<?= $firstyear2nd['units']; ?>">
                                        <input type="hidden" name="id" value="<?= $firstyear2nd['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $firstyear2nd['course_code']; ?>">
                                        <input type="hidden" name="price" value="<?= $firstyear2nd['price']; ?>">
                                    </form>
                                    <form action="<?php htmlspecialchars("PHP_SELF"); ?>" method="POST">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $firstyear2nd['subject_title']; ?> ?');">
                                        <input type="hidden" name="id" value="<?= $firstyear2nd['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $firstyear2nd['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php $sum += $firstyear2nd['units']  ?>
                        <?php $totalAmount += $firstyear2nd['amount']  ?>
                        <?php } ?>
                        <tr>
                        <td colspan="2">Total Units</td>
                        <td><?= $sum; ?></td>
                        <td>Total Amount : <?= number_format($totalAmount,2); ?></td>
                        <td></td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Subject Code</th>
                        <th>Second Year, First Term</th>
                        <th>Units</th>
                        <th>Price</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                        <?php $sum = 0; ?>
                        <?php $totalAmount = 0; ?>
                        <?php foreach($secondyear1sts as $secondyear1st) {?>
                        <tr>
                            <td data-label="Subject Code"> <?= $secondyear1st['subject_code']; ?> </td>
                            <td data-label="Subject Title"> <?= $secondyear1st['subject_title']; ?> </td>
                            <td data-label="Units"> <?= $secondyear1st['units']; ?> </td> 
                            <td data-label="Units"> <?= $secondyear1st['price']; ?> </td> 
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form action="editSubject.php" method="POST">
                                        <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                        <input type="hidden" name="yearlevel" value="<?= $secondyear1st['yearlevel']     ?>">
                                        <input type="hidden" name="term" value="<?= $secondyear1st['term'] ?>">
                                        <input type="hidden" name="subjectcode" value="<?= $secondyear1st    ['subject_code']; ?>">
                                        <input type="hidden" name="subjecttitle" value="<?= $secondyear1st   ['subject_title']; ?>">
                                        <input type="hidden" name="units" value="<?= $secondyear1st['units']; ?>">
                                        <input type="hidden" name="id" value="<?= $secondyear1st['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $secondyear1st['course_code']; ?>">
                                        <input type="hidden" name="price" value="<?= $secondyear1st['price']; ?>">
                                    </form>
                                    <form action="<?php htmlspecialchars("PHP_SELF"); ?>" method="POST">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $secondyear1st['subject_title']; ?> ?');">
                                        <input type="hidden" name="id" value="<?= $secondyear1st['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $secondyear1st['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php $sum += $secondyear1st['units']  ?>
                        <?php $totalAmount += $secondyear1st['amount']  ?>
                        <?php } ?>
                        <tr>
                        <td colspan="2">Total Units</td>
                        <td><?= $sum; ?></td>
                        <td>Total Amount : <?= number_format($totalAmount,2); ?></td>
                        <td></td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Subject Code</th>
                        <th>Second Year, Second Term</th>
                        <th>Units</th>
                        <th>Price</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                        <?php $sum = 0; ?>
                        <?php $totalAmount = 0; ?>
                        <?php foreach($secondyear2nds as $secondyear2nd) {?>
                        <tr>
                            <td data-label="Subject Code"> <?= $secondyear2nd['subject_code']; ?> </td>
                            <td data-label="Subject Title"> <?= $secondyear2nd['subject_title']; ?> </td>
                            <td data-label="Units"> <?= $secondyear2nd['units']; ?> </td>
                            <td data-label="Units"> <?= $secondyear2nd['price']; ?> </td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form action="editSubject.php" method="POST">
                                        <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                        <input type="hidden" name="yearlevel" value="<?= $secondyear2nd['yearlevel']     ?>">
                                        <input type="hidden" name="term" value="<?= $secondyear2nd['term'] ?>">
                                        <input type="hidden" name="subjectcode" value="<?= $secondyear2nd    ['subject_code']; ?>">
                                        <input type="hidden" name="subjecttitle" value="<?= $secondyear2nd   ['subject_title']; ?>">
                                        <input type="hidden" name="units" value="<?= $secondyear2nd['units']; ?>">
                                        <input type="hidden" name="id" value="<?= $secondyear2nd['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $secondyear2nd['course_code']; ?>">
                                        <input type="hidden" name="price" value="<?= $secondyear2nd['price']; ?>">
                                    </form>
                                    <form action="<?php htmlspecialchars("PHP_SELF"); ?>" method="POST">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $secondyear2nd['subject_title']; ?> ?');">
                                        <input type="hidden" name="id" value="<?= $secondyear2nd['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $secondyear2nd['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php $sum += $secondyear2nd['units']  ?>
                        <?php $totalAmount += $secondyear2nd['amount']  ?>
                        <?php } ?>
                        <tr>
                        <td colspan="2">Total Units</td>
                        <td><?= $sum; ?></td>
                        <td>Total Amount : <?= number_format($totalAmount,2); ?></td>
                        <td></td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Subject Code</th>
                        <th>Third Year, First Term</th>
                        <th>Units</th>
                        <th>Price</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                        <?php $sum = 0; ?>
                        <?php $totalAmount = 0; ?>
                        <?php foreach($thirdyear1sts as $thirdyear1st) {?>
                        <tr>
                            <td data-label="Subject Code"> <?= $thirdyear1st['subject_code']; ?> </td>
                            <td data-label="Subject Title"> <?= $thirdyear1st['subject_title']; ?> </td>
                            <td data-label="Units"> <?= $thirdyear1st['units']; ?> </td>
                            <td data-label="Price"> <?= $thirdyear1st['price']; ?> </td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                <form action="editSubject.php" method="POST">
                                        <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                        <input type="hidden" name="yearlevel" value="<?= $thirdyear1st['yearlevel']     ?>">
                                        <input type="hidden" name="term" value="<?= $thirdyear1st['term'] ?>">
                                        <input type="hidden" name="subjectcode" value="<?= $thirdyear1st    ['subject_code']; ?>">
                                        <input type="hidden" name="subjecttitle" value="<?= $thirdyear1st   ['subject_title']; ?>">
                                        <input type="hidden" name="units" value="<?= $thirdyear1st['units']; ?>">
                                        <input type="hidden" name="id" value="<?= $thirdyear1st['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $thirdyear1st['course_code']; ?>">
                                        <input type="hidden" name="price" value="<?= $thirdyear1st['price']; ?>">
                                    </form>
                                    <form action="<?php htmlspecialchars("PHP_SELF"); ?>" method="POST">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $thirdyear1st['subject_title']; ?> ?');">
                                        <input type="hidden" name="id" value="<?= $thirdyear1st['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $thirdyear1st['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php $sum += $thirdyear1st['units']  ?>
                        <?php $totalAmount += $thirdyear1st['amount']  ?>
                        <?php } ?>
                        <tr>
                        <td colspan="2">Total Units</td>
                        <td><?= $sum; ?></td>
                        <td>Total Amount : <?= number_format($totalAmount,2); ?></td>
                        <td></td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Subject Code</th>
                        <th>Third Year, Second Term</th>
                        <th>Units</th>
                        <th>Price</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                        <?php $sum = 0; ?>
                        <?php $totalAmount = 0; ?>
                        <?php foreach($thirdyear2nds as $thirdyear2nd) {?>
                        <tr>
                            <td data-label="Subject Code"> <?= $thirdyear2nd['subject_code']; ?> </td>
                            <td data-label="Subject Title"> <?= $thirdyear2nd['subject_title']; ?> </td>
                            <td data-label="Units"> <?= $thirdyear2nd['units']; ?> </td>
                            <td data-label="Price"> <?= $thirdyear2nd['price']; ?> </td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form action="editSubject.php" method="POST">
                                        <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                        <input type="hidden" name="yearlevel" value="<?= $thirdyear2nd['yearlevel']     ?>">
                                        <input type="hidden" name="term" value="<?= $thirdyear2nd['term'] ?>">
                                        <input type="hidden" name="subjectcode" value="<?= $thirdyear2nd    ['subject_code']; ?>">
                                        <input type="hidden" name="subjecttitle" value="<?= $thirdyear2nd   ['subject_title']; ?>">
                                        <input type="hidden" name="units" value="<?= $thirdyear2nd['units']; ?>">
                                        <input type="hidden" name="id" value="<?= $thirdyear2nd['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $thirdyear2nd['course_code']; ?>">
                                        <input type="hidden" name="price" value="<?= $thirdyear2nd['price']; ?>">
                                    </form>
                                    <form action="<?php htmlspecialchars("PHP_SELF"); ?>" method="POST">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $thirdyear2nd['subject_title']; ?> ?');">
                                        <input type="hidden" name="id" value="<?= $thirdyear2nd['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $thirdyear2nd['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php $sum += $thirdyear2nd['units']  ?>
                        <?php $totalAmount += $thirdyear2nd['amount']  ?>
                        <?php } ?>
                        <tr>
                        <td colspan="2">Total Units</td>
                        <td><?= $sum; ?></td>
                        <td>Total Amount : <?= number_format($totalAmount,2); ?></td>
                        <td></td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Subject Code</th>
                        <th>Fourth Year, First Term</th>
                        <th>Units</th>
                        <th>Price</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                        <?php $sum = 0; ?>
                        <?php $totalAmount = 0; ?>
                        <?php foreach($fourthyear1sts as $fourthyear1st) {?>
                        <tr>
                            <td data-label="Subject Code"> <?= $fourthyear1st['subject_code']; ?> </td>
                            <td data-label="Subject Title"> <?= $fourthyear1st['subject_title']; ?> </td>
                            <td data-label="Units"> <?= $fourthyear1st['units']; ?> </td>
                            <td data-label="Price"> <?= $fourthyear1st['price']; ?> </td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form action="editSubject.php" method="POST">
                                        <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                        <input type="hidden" name="yearlevel" value="<?= $fourthyear1st['yearlevel']     ?>">
                                        <input type="hidden" name="term" value="<?= $fourthyear1st['term'] ?>">
                                        <input type="hidden" name="subjectcode" value="<?= $fourthyear1st    ['subject_code']; ?>">
                                        <input type="hidden" name="subjecttitle" value="<?= $fourthyear1st   ['subject_title']; ?>">
                                        <input type="hidden" name="units" value="<?= $fourthyear1st['units']; ?>">
                                        <input type="hidden" name="id" value="<?= $fourthyear1st['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $fourthyear1st['course_code']; ?>">
                                        <input type="hidden" name="price" value="<?= $fourthyear1st['price']; ?>">
                                    </form>
                                    <form action="<?php htmlspecialchars("PHP_SELF"); ?>" method="POST">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $fourthyear1st['subject_title']; ?> ?');">
                                        <input type="hidden" name="id" value="<?= $fourthyear1st['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $fourthyear1st['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php $sum += $fourthyear1st['units']  ?>
                        <?php $totalAmount += $fourthyear1st['amount']  ?>
                        <?php } ?>
                        <tr>
                        <td colspan="2">Total Units</td>
                        <td><?= $sum; ?></td>
                        <td>Total Amount : <?= number_format($totalAmount,2); ?></td>
                        <td></td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>Subject Code</th>
                        <th>Fourth Year, Second Term</th>
                        <th>Units</th>
                        <th>Price</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                        <?php $sum = 0; ?>
                        <?php $totalAmount = 0; ?>
                        <?php foreach($fourthyear2nds as $fourthyear2nd) {?>
                        <tr>
                            <td data-label="Subject Code"> <?= $fourthyear2nd['subject_code']; ?> </td>
                            <td data-label="Subject Title"> <?= $fourthyear2nd['subject_title']; ?> </td>
                            <td data-label="Units"> <?= $fourthyear2nd['units']; ?> </td>
                            <td data-label="Price"> <?= $fourthyear2nd['price']; ?> </td>
                            <td data-label="Option">
                                <div class="opt_btn">
                                    <form action="editSubject.php" method="POST">
                                        <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                        <input type="hidden" name="yearlevel" value="<?= $fourthyear2nd['yearlevel']     ?>">
                                        <input type="hidden" name="term" value="<?= $fourthyear2nd['term'] ?>">
                                        <input type="hidden" name="subjectcode" value="<?= $fourthyear2nd    ['subject_code']; ?>">
                                        <input type="hidden" name="subjecttitle" value="<?= $fourthyear2nd   ['subject_title']; ?>">
                                        <input type="hidden" name="units" value="<?= $fourthyear2nd['units']; ?>">
                                        <input type="hidden" name="id" value="<?= $fourthyear2nd['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $fourthyear2nd['course_code']; ?>">
                                        <input type="hidden" name="price" value="<?= $fourthyear2nd['price']; ?>">
                                    </form>
                                    <form action="<?php htmlspecialchars("PHP_SELF"); ?>" method="POST">
                                        <input type="submit" class="btn-submit" name="Delete" value="DELETE" onclick="javascript:return confirm('Are you sure to Delete this <?= $fourthyear2nd['subject_title']; ?> ?');">
                                        <input type="hidden" name="id" value="<?= $fourthyear2nd['id']; ?>">
                                        <input type="hidden" name="coursecode" value="<?= $fourthyear2nd['course_code']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php $sum += $fourthyear2nd['units']  ?>
                        <?php $totalAmount += $fourthyear2nd['amount']  ?>
                        <?php } ?>
                        <tr>
                        <td colspan="2">Total Units</td>
                        <td><?= $sum; ?></td>
                        <td>Total Amount : <?= number_format($totalAmount,2); ?></td>
                        <td></td>
                        </tr>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
        </div>
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modal.js"></script>
</body>
</html>