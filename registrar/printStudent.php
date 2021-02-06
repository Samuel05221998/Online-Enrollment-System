<?php
    require_once('../enrollmentclass.php');
    

    $section_id = " ";
    if(empty($_GET['section_id'])) {
        $section_id = null;
    } else {
        $section_id = $_GET['section_id'];
    }

    $student_id = " ";
    if(empty($_GET['student_id'])) {
        $student_id = null;
    } else {
        $student_id = $_GET['student_id'];
    }

    $coursecode = " ";
    if(empty($_GET['coursecode'])) {
        $coursecode = null;
    } else {
        $coursecode = $_GET['coursecode'];
    }

    $yearlevel = " ";
    if(empty($_GET['yearlevel'])) {
        $yearlevel = null;
    } else {
        $yearlevel = $_GET['yearlevel'];
    }

    $term = " ";
    if(empty($_GET['term'])) {
        $term = null;
    } else {
        $term = $_GET['term'];
    }

    $sycode = " ";
    if(empty($_GET['sycode'])) {
        $sycode = null;
    } else {
        $sycode = $_GET['sycode'];
    }

    $printStudents = $olenrollment->printStudent($section_id, $student_id);
    $student = $olenrollment->viewEnrollStudent($student_id, $sycode);
    $fees = $olenrollment->viewFee($yearlevel, $term, $coursecode);
    $viewPayment = $olenrollment->sumPayment($sycode, $student_id);
    $userdetails = $olenrollment->get_userdata();
    $viewOpenSY = $olenrollment->getOpenSY();
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
    <link rel = "stylesheet" href = "print.css" media="print" />
    <link rel="stylesheet" href="../css/registrar.css" media="screen" />
    
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
                                <a href="enrollaccount.php?sycode=<?= $viewOpenSY['sycode'] ?>" class="collapse_sublink">Enrollment&nbsp;Account</a>
                                <a href="unenrollaccount.php?sycode=<?= $viewOpenSY['sycode'] ?>" class="collapse_sublink">Unenrollment&nbsp;Account</a>
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
                <h2>Online Enrollment System</h2>
            </div>
            <table class="table">
                <thead>
                    <th>SY & Term</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Course Code</th>
                    <th>Year Level</th>
                    <th>Term</th>
                    <th>Section Name</th>
                </thead>
                <tbody>
                    <td><?= $student['sycode'] ?></td>
                    <td><?= $student['student_id']; ?></td>
                    <td><?= $student['first_name']." ".$student['middle_name']." ".$student['last_name']." ".$student['suffix_name'] ?></td>
                    <td><?= $student['coursecode']; ?></td>
                    <td><?= $student['yearlevel']; ?></td>
                    <td><?= $student['term']; ?></td>
                    <td><?= $student['section_name']; ?></td>
                </tbody>
            </table>
            <table class="table">
                <thead>
                    <th>Subject Description</th>
                    <th>Units</th>
                    <th>Section</th>
                    <th>Days</th>
                    <th>Time</th>
                    <th>Teacher</th>
                </thead>
                <?php $totalAmount = 0; ?> 
                <?php if(is_array($printStudents) || is_object($printStudents))  {?>
            <?php foreach($printStudents as $printStudent) {?>
                <tbody>
                    <td><?= $printStudent['subject_title'] ?></td>
                    <td><?= $printStudent['units'] ?></td>
                    <td><?= $printStudent['section_name'] ?></td>
                    <td><?= $printStudent['days'] ?></td>
                    <td><?= date('h:i A',strtotime($printStudent['timefrom'])); ?> - <?= date('h:i A',strtotime($printStudent['timeto'])); ?></td>
                    <td><?= $printStudent['deptname'] ?></td>
                    <?php $totalAmount += $printStudent['amount']  ?>
                </tbody>
            <?php } ?>
            <?php } else { echo "No data"; } ?>
            </table>
            <div class="fee-details">
                <div class="row-details">
                    <div class="text-details">
                        <label>Tuition Fee :</label>  
                    </div>
                    <div class="price-details">
                        <label><?= number_format($totalAmount, 2); ?></label>
                    </div>
                </div>
                    <?php $Nfee = 0 ?>
                    <?php if(is_array($fees) || is_object($fees))  {?>
                    <?php ?>
                    <?php foreach($fees as $fee) {?>
                <div class="row-details">
                    <div class="text-details">
                        <?= $fee['description']; ?> : 
                    </div>
                    <div class="price-details">
                        <?= $fee['amount']; ?>
                    </div>
                </div>
                    <?php $Nfee += $fee['amount']; ?> 
                    <?php } ?>
                <?php } else { echo ""; }?> 
                <?php $totalTuition = $totalAmount + $Nfee ?>
                <?php $uponenrollment = $totalTuition * $student['uponenrollment']; ?>
                <?php $prelim = $totalTuition * $student['prelim']; ?>
                <?php $midterm = $totalTuition * $student['midterm']; ?>
                <?php $prefinal = $totalTuition * $student['prefinal']; ?>
                <?php $final = $totalTuition * $student['final']; ?>
                <!-- <div class="tuition"> -->
                <div class="row-details">
                    <div class="text-details">
                        <strong><label>Total Tuition Fee :</label>
                    </div>
                    <div class="price-details">
                        <?= number_format($totalTuition, 2); ?></strong>
                    </div>
                </div>
            </div>
            <div class="type-details">
                <div class="row-details">
                    <div class="text-details">
                        <label>Fee Type : </label>
                    </div>
                    <div class="price-details">
                        <?= $student['feetype'] ?><br>
                    </div>
                </div>
                <div class="row-details">
                    <div class="text-details">
                        <label>Upon Enrollment : </label>
                    </div>
                    <div class="price-details">
                        <?= ($student['uponenrollment']=="0.00") ? ' ' :  number_format($uponenrollment,2); ?>
                    </div>
                </div>
                <div class="<?= ($student['prelim']=="0.00") ? '' : 'row-details'?>">
                    <div class="text-details">
                        <?= ($student['prelim']=="0.00") ? '' :  "<label>Prelim : </label>" ?>
                    </div>
                    <div class="price-details">
                        <?= ($student['prelim']=="0.00") ? '' :  number_format($prelim,2) ?>
                    </div>
                </div>
                <div class="<?= ($student['midterm']=="0.00") ? '' : 'row-details'?>">
                    <div class="text-details">
                        <?= ($student['midterm']=="0.00") ? '' :  "<label>Midterm : </label>" ?>
                    </div>
                    <div class="price-details">
                        <?= ($student['midterm']=="0.00") ? '' :  number_format($midterm,2) ?>
                    </div>
                </div>
                <div class="<?= ($student['prefinal']=="0.00") ? '' : 'row-details'?>">
                    <div class="text-details">
                        <?= ($student['prefinal']=="0.00") ? ' ' :  "<label>PreFinal : </label>" ?>
                    </div>
                    <div class="price-details">
                        <?= ($student['prefinal']=="0.00") ? ' ' :  number_format($prefinal,2);?>
                    </div>
                </div>
                <div class="<?= ($student['final']=="0.00") ? '' : 'row-details'?>">
                    <div class="text-details">
                        <?= ($student['final']=="0.00") ? ' ' :  "<label>Final : </label>" ?>
                    </div>
                    <div class="price-details">
                        <?= ($student['final']=="0.00") ? ' ' :  number_format($final,2);?>
                    </div>
                </div>
                <?php $totalbalance = $uponenrollment + $prelim + $midterm + $prefinal + $final; ?>
                <div class="row-details">
                    <div class="text-details">
                        <label>Payment :</label>  
                    </div>
                    <div class="price-details">
                        <?= (isset($viewPayment['totalpayment'])) ? $viewPayment['totalpayment'] : '0.00' ?>
                    </div>
                </div>
                <?php $balance = $totalbalance - $viewPayment['totalpayment']; ?>
                <div class="row-details">
                    <div class="text-details">
                        <label><strong> Balance : </label>  
                    </div>
                    <div class="price-details">
                    <?= number_format($balance,2); ?></strong>
                    </div>
                </div>
            </div>
            <div class="print-btn-submit">
                <button onclick="window.print()" class="print-btn" id="print-btn">Save and Print</button>
            </div>
        </div>
    </div>
    <script src="../js/course.js"></script>
</body>
</html>