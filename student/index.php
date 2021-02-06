<?php
    require_once('../enrollmentclass.php');
    
    // $id = $_GET['id'];
    $userdetails = $olenrollment->get_userdata();
    $student_id = $userdetails['student_id'];
    $viewOpenSY = $olenrollment->getOpenSY();
    $sycode = $viewOpenSY['sycode'];
    $student = $olenrollment->showEnrollStudent($sycode, $student_id);
    $viewPayment = $olenrollment->sumPayment($sycode, $student_id);
    $sectionid = $student['section_id'];
    $yearlevel = $student['yearlevel'];
    $term = $student['term'];
    $coursecode = $student['coursecode'];
    $printStudents = $olenrollment->studentSubjects($sycode, $sectionid, $student_id);
    $fees = $olenrollment->viewFee($yearlevel, $term, $coursecode);

    if(isset($userdetails)) {
        if($userdetails['position'] != "Student") {

            header("Location: ../login.php");
        }
    } else {
        header("Location: ../login.php");
    }

    if(isset($student))
    {
        if($student['status'] != "Enrolled")
        {
            header("Location: select-payment.php");
        } 
    } else {
        header("Location: select-payment.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <title>Online Enrollment System</title>
    <link rel="stylesheet" href="../css/student.css">
<script>
    
    function getAmount(){
        var loadhr = new XMLHttpRequest();
        var loadurl = "getAmount.php";
        var totalTuition = document.getElementById("totalTuition").value;
        var selectpayment = document.getElementById("selectpayment").value;
        var loadvars = "totalTuition="+totalTuition+"&selectpayment="+selectpayment;
        loadhr.open("GET", loadurl+"?"+loadvars, true);
        loadhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        loadhr.onreadystatechange = function() {
    	    if(loadhr.readyState == 4 && loadhr.status == 200) {
    		    var return_data = loadhr.responseText;
    			document.getElementById("percent").innerHTML = return_data;
    	    }
        }
        loadhr.send(loadvars);
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
                        <a href="payment.php" class="nav_link">
                            <img src="./../images/fees.ico" class="nav_icon"></img>
                            <span class="nav_name">Payment</span>
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
                <h2>Student Information</h2>
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
                    <td><?= $viewOpenSY['sycode'] ?></td>
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
                        <strong><label> Tuition Fee : </label>
                    </div>
                    <div class="price-details">
                        <?= number_format($totalAmount, 2); ?></strong>
                    </div>
                </div>
                <?php $Nfee = 0 ?>
                <?php if(is_array($fees) || is_object($fees))  {?>
                <?php foreach($fees as $fee) {?>
                    <div class="row-details">
                        <div class="text-details">
                            <label><?= $fee['description']; ?> :</label> 
                        </div>
                        <div class="price-details">
                            <label><?= $fee['amount']; ?></label>
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
                <div class="row-details">
                    <div class="text-details">
                        <label><strong>Total Tuition Fee : </label>
                    </div>
                    <div class="price-details">
                        <?= number_format($totalTuition, 2); ?></strong>
                    </div>
                </div>
            </div>
            <div class="fee-details">
                <input type="hidden" name="" id="totalTuition" value="<?= $totalTuition ?>" oncopy="getAmount();">
                <div class="row-details">
                    <div class="text-details">
                        <label>Fee Type : </label>
                    </div>
                    <div class="price-details">
                        <label><?= $student['feetype'] ?></label>
                    </div>
                </div>
                <div class="row-details">
                    <div class="text-details">
                        <label>Upon Enrollment : </label>
                    </div>
                    <div class="price-details">
                        <?= ($student['uponenrollment']=="0.00") ? ' ' :  number_format($uponenrollment,2);?>
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
                <button class="modal-btn"<?= ($student['percentpayment']>='0.90' ? 'hidden': '') ?>>PAY FEE</button>
            </div>
                <form method = "POST" action = "paynow.php">
                <div class = "modal-bg">
                    <div class = "modal">
                        <h2>Pay Tuition Fee</h2>
                        <label for="name">Payment Method</label>
                        <select name="remarks" id="selectpayment" onchange="getAmount();">
                            <option  disabled selected value> -- Select an option -- </option>
                            <option value="<?php if($student['feetype']=="Full Payment") { echo '0.90|Upon Enrollment'; } else { echo '0.40|Upon Enrollment'; } ?>" <?php if($student['feetype']=="Full Payment") { if($student['percentpayment']>=0.90) { echo 'hidden'; } else { echo ''; } } else if($student['feetype']=="Installment") { if($student['percentpayment']>=0.40) { echo 'hidden'; } else { echo ''; } } ?>>Upon Enrollment</option>
                            <option value="<?= ($student['percentpayment']>=0.40) ? '0.16|Prelim' : '0.56|Upon Enrollment, Prelim'; ?>" <?php if($student['feetype']=="Full Payment") { echo 'hidden'; }  else if($student['feetype']=="Installment") { if($student['percentpayment']>=0.56) { echo 'hidden'; } else { echo ''; } } ?>>Prelim</option>
                            <option value="<?php if($student['percentpayment']>=0.56) { echo '0.16|Midterm'; } else if(($student['percentpayment']>=0.40) && ($student['percentpayment']<=0.55)) { echo '0.32|Prelim, Midterm'; } else { echo '0.72|Upon Enrollment, Prelim, Midterm'; } ?>"<?php if($student['feetype']=="Full Payment") { echo 'hidden'; } else if($student['feetype']=="Installment") { if($student['percentpayment']>=0.72) { echo 'hidden'; } else { echo ''; } } ?>>Midterm</option>
                            <option value="<?php if($student['percentpayment']>=0.72) { echo '0.14|Pre Final'; } else if(($student['percentpayment']>=0.56) &&($student['percentpayment']<=0.71)) { echo '0.30|Midterm, Pre Final'; } else if(($student['percentpayment']>=0.40) &&($student['percentpayment']<=0.55)) { echo '0.46|Prelim, Midterm, Pre Final'; }else { echo '0.86|Upon Enrollment, Prelim, Midterm, Pre Final'; } ?>"<?php if($student['feetype']=="Full Payment") { echo 'hidden'; } else if($student['feetype']=="Installment") { if($student['percentpayment']>=0.86) { echo 'hidden'; } else { echo ''; } } ?>>Pre Final</option>
                            <option value="<?php if($student['percentpayment']>=0.86) { echo '0.14|Final'; } else if(($student['percentpayment']>=0.72) &&($student['percentpayment']<=0.85)) { echo '0.28|Pre Final, Final'; } else if(($student['percentpayment']>=0.56) &&($student['percentpayment']<=0.71)) { echo '0.44|Midterm, Pre Final, Final'; } else if(($student['percentpayment']>=0.40) &&($student['percentpayment']<=0.55)) { echo '0.60|Prelim, Midterm, Pre Final, Final'; }else { echo '1|Upon Enrollment, Prelim, Midterm, Pre Final, Final'; } ?>"<?php if($student['feetype']=="Full Payment") { echo 'hidden'; } else if($student['feetype']=="Installment") { if($student['percentpayment']==1.00) { echo 'hidden'; } else { echo ''; } } ?>>Final</option>
                        </select>
                        <label for="name">Amount:</label>
                        <div id="percent">
                            <input type = "text" class="text-percent" name = "amount" readonly>
                        </div>
                        <input type="hidden" name="studentname" id="" value="<?= $student['studentname']; ?>">
                        <input type="hidden" name="studentid" value="<?= $userdetails['student_id']; ?>">
                        <input type="hidden" name="sycode" value="<?= $viewOpenSY['sycode'] ?>">
                        <input type="hidden" name="enrollmentid" id="" value="<?= $student['enrollmentid'] ?>">
                        <button class = "sub" name = "btnSave">Proceed</button>
                        <span class = "modal-close">X</span>
                    </div>
                </div>
                </form>
        </div>
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modal.js"></script>
</body>
</html>