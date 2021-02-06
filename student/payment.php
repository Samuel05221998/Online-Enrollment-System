<?php
    require_once('../enrollmentclass.php');
    
    // $id = $_GET['id'];
    $userdetails = $olenrollment->get_userdata();
    $student_id = $userdetails['student_id'];
    $viewOpenSY = $olenrollment->getOpenSY();
    $sycode = $viewOpenSY['sycode'];
    $student = $olenrollment->showEnrollStudent($sycode, $student_id);
    $viewPayment = $olenrollment->sumPayment($sycode, $student_id);
    $viewStudentPayment = $olenrollment->viewPaymentStudent($sycode, $student_id);
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
                <h2>View Payments for <?= $viewOpenSY['sycode']; ?></h2>
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
                    <th>Description</th>
                    <th>Date</th>
                    <th>Payers Name</th>
                    <th>Amount</th>
                </thead>
                <tbody>
                    <?php $totalAmount = 0; ?> 
                    <?php $totalPay = 0; ?>
                    <?php if(is_array($printStudents) || is_object($printStudents))  {?>
            <?php foreach($printStudents as $printStudent) {?>
                <?php $totalAmount += $printStudent['amount']  ?>
                <?php } ?>
            <?php } else { echo "No data"; } ?>
                <?php if(is_array($viewStudentPayment) || is_object($viewStudentPayment))  {?>
                <?php foreach($viewStudentPayment as $row) {?>
                    <td><?= date('F j'. ', ' . 'Y', strtotime($row['created'])); ?></td>
                    <td><?= $row['payer_name'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['payment_gross'] .' '.$row['currency_code']  ?></td>
                    <?php $totalPay += $row['payment_gross'] ?> 
                </tbody>
                <?php } ?>
                <?php } else { echo "No data"; } ?>
                <tr>
                    <td colspan="3">Total Amount : </td>
                    <td><?= number_format($totalPay, 2); ?> PHP</td>
                </tr>
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
                        <?= (isset($viewPayment['totalpayment'])) ? $viewPayment['totalpayment'] : '0.00' ?><br> </p>
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
        </div>
    </div>
    <script src="../js/course.js"></script>
</body>
</html>
