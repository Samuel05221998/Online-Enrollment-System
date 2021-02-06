<?php
    require_once('../enrollmentclass.php');
    
    // $id = $_GET['id'];
    $userdetails = $olenrollment->get_userdata();
    $viewOpenSY = $olenrollment->getOpenSY();
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
    $olenrollment->updateStudentFees($_POST);

    if(isset($userdetails)) {
        if($userdetails['position'] != "Student") {

            header("Location: ../login.php");
        }
    } else {
        header("Location: ../login.php");
    }

    if(isset($student))
    {
        if($student['status'] == "Enrolled")
        {
            header("Location: index.php");
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
    <link rel="stylesheet" href="../css/registrar.css">
    <script>
    function getSelectOption() {
        var hr = new XMLHttpRequest();
        var url = "uponenrollment.php";
        var totalFees = document.getElementById("totalFees").value;
        var selectoption = document.getElementById("selectoption").value;
        var vars = "totalFees="+totalFees+"&selectoption="+selectoption;
        hr.open("GET", url+"?"+vars, true);
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr.onreadystatechange = function() {
            if(hr.readyState == 4 && hr.status == 200) {
        	    var return_data = hr.responseText;
        		document.getElementById("enrollprice").innerHTML = return_data;
            }
        }
        hr.send(vars);
    }
    function getPrelim() {
            var hr = new XMLHttpRequest();
            var url = "getprelim.php";
            var totalFees = document.getElementById("totalFees").value;
            var selectoption = document.getElementById("selectoption").value;
            var vars = "totalFees="+totalFees+"&selectoption="+selectoption;
            hr.open("GET", url+"?"+vars, true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.onreadystatechange = function() {
    	        if(hr.readyState == 4 && hr.status == 200) {
    	    	    var return_data = hr.responseText;
    	    		document.getElementById("prelim").innerHTML = return_data;
    	        }
            }
            hr.send(vars);
        }

    function getMidterm() {
        var hr = new XMLHttpRequest();
        var url = "getmidterm.php";
        var totalFees = document.getElementById("totalFees").value;
        var selectoption = document.getElementById("selectoption").value;
        var vars = "totalFees="+totalFees+"&selectoption="+selectoption;
        hr.open("GET", url+"?"+vars, true);
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr.onreadystatechange = function() {
            if(hr.readyState == 4 && hr.status == 200) {
        	    var return_data = hr.responseText;
        		document.getElementById("midterm").innerHTML = return_data;
            }
        }
        hr.send(vars);
    }
    function getPrefinal() {
        var hr = new XMLHttpRequest();
        var url = "getprefinal.php";
        var totalFees = document.getElementById("totalFees").value;
        var selectoption = document.getElementById("selectoption").value;
        var vars = "totalFees="+totalFees+"&selectoption="+selectoption;
        hr.open("GET", url+"?"+vars, true);
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr.onreadystatechange = function() {
            if(hr.readyState == 4 && hr.status == 200) {
        	    var return_data = hr.responseText;
        		document.getElementById("prefinal").innerHTML = return_data;
            }
        }
        hr.send(vars);
    }
    function getFinal() {
        var hr = new XMLHttpRequest();
        var url = "getfinal.php";
        var totalFees = document.getElementById("totalFees").value;
        var selectoption = document.getElementById("selectoption").value;
        var vars = "totalFees="+totalFees+"&selectoption="+selectoption;
        hr.open("GET", url+"?"+vars, true);
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr.onreadystatechange = function() {
            if(hr.readyState == 4 && hr.status == 200) {
        	    var return_data = hr.responseText;
        		document.getElementById("final").innerHTML = return_data;
            }
        }
        hr.send(vars);
    }
    function getAmountDue() {
        var hr = new XMLHttpRequest();
        var url = "getamountdue.php";
        var totalFees = document.getElementById("totalFees").value;
        var selectoption = document.getElementById("selectoption").value;
        var vars = "totalFees="+totalFees+"&selectoption="+selectoption;
        hr.open("GET", url+"?"+vars, true);
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr.onreadystatechange = function() {
            if(hr.readyState == 4 && hr.status == 200) {
        	    var return_data = hr.responseText;
        		document.getElementById("amountdue").innerHTML = return_data;
            }
        }
        hr.send(vars);
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
                <h2>Open Semester</h2>
                <label><?= $viewOpenSY['sycode'] ?></label>
            </div>
            <?php $totalAmount = 0; ?> 
            <?php if(is_array($printStudents) || is_object($printStudents))  {?>
            <?php foreach($printStudents as $printStudent) {?>
                    <?php $totalAmount += $printStudent['amount']  ?>
            <?php } ?>
            <?php } else { echo "No data"; } ?>
            <div class="fee-details">
                <div class="row-details">
                    <div class="text-details">
                        <b>Tuition Fee : 
                    </div>
                    <div class="price-details">  
                        <?= number_format($totalAmount, 2); ?></b>
                    </div>
                </div>
            <?php $Nfee = 0 ?>
                <?php if(is_array($fees) || is_object($fees))  {?>
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
            <?php $totalPay = $uponenrollment + $prelim + $midterm + $prefinal + $final; ?>
            <div class="row-details">
                <div class="text-details">
                    <b>Total Tuition Fee : 
                </div>        
                <div class="price-details">
                    <?= number_format($totalTuition, 2); ?></b>
                </div>
            </div>
            </div>
            <input type="hidden" name="totalFees" id="totalFees" value="<?= $totalTuition; ?>">
            <div class="select-payment">
            <h2>Please select your payment method and click submit</h2>
            <form action="<?php htmlspecialchars("PHP_SELF"); ?>" method="POST">
                <select name="feetype" class="print-btn" id="selectoption" onchange="getSelectOption(); getPrelim(); getMidterm(); getPrefinal(); getFinal(); getAmountDue();">
                    <option disabled selected value> -- Select an option -- </option>
                    <option value="Full Payment"<?= ($student['feetype']=='Full Payment') ? 'selected' : '';  ?>>Full Payment</option>
                    <option value="Installment" <?= ($student['feetype']=='Installment') ? 'selected' : '';  ?>>Installment</option>
                </select>
                <div style="margin-top:10px;"></div>
                <input type="hidden" name="uponenrollment" id="" value="<?= $student['uponenrollment'] ?>">
                <input type="hidden" name="prelim" id="" value="<?= $student['prelim'] ?>">
                <input type="hidden" name="midterm" id="" value="<?= $student['midterm'] ?>">
                <input type="hidden" name="prefinal" id="" value="<?= $student['prefinal'] ?>">
                <input type="hidden" name="final" id="" value="<?= $student['final'] ?>">
                <div id="enrollprice">
                    <label>Upon Enrollment : </label><label><?php if($student['feetype']=='Full Payment') { echo number_format($uponenrollment,2); } else { echo number_format($uponenrollment,2); }?></label>
                </div>
                <div id="prelim">
                <?= ($prelim=="0.00") ? ' ' :  "<label>Prelim : </label>" ?><label><?= ($prelim=="0.00") ? ' ' :  number_format($prelim,2). '<br>';?></label>
                </div>
                <div id="midterm">
                <?= ($student['midterm']=="0.00") ? ' ' :  "<label>Midterm : </label>" ?><label><?= ($midterm=="0.00") ? ' ' :  number_format($midterm,2). '<br>';?></label>
                </div>
                <div id="prefinal">
                <?= ($prefinal=="0.00") ? ' ' :  "<label>PreFinal : </label>" ?><label><?= ($prefinal=="0.00") ? ' ' :  number_format($prefinal,2). '<br>';?></label>
                </div>
                <div id="final">
                <?= ($final=="0.00") ? ' ' :  "<label>Final : </label>" ?><label><?= ($final=="0.00") ? ' ' :  number_format($final,2). '<br>';?></label>
                </div>
                <div id="amountdue">
                <strong><label>Total Amount : </label><label><?= number_format($totalPay,2) ?></label></strong>
                </div>
                <input type="hidden" name="studentid" id="" value="<?= $student['student_id']; ?>">
                <input type="hidden" name="sycode" id="" value="<?= $viewOpenSY['sycode'] ?>">
                <div style="margin-top:10px;"></div>
                <input type="submit" class="print-btn" name="update" value="Update">
            </form>
            </div>
        </div>
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modal.js"></script>
</body>
</html>