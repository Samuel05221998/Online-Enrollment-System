<?php
    require_once('../enrollmentclass.php');

    $scourse = " ";
    if(empty($_GET['course'])) {
        $scourse = null;
    } else {
        $scourse = $_GET['course'];
    }

    $year = " ";
    if(empty($_GET['year'])) {
        $year = null;
    } else {
        $year = $_GET['year'];
    }

    $id = " ";
    if(empty($_GET['id'])) {
        $id = null;
    } else {
        $id = $_GET['id'];
    }

    // $name = " ";
    // if(empty($_GET['name'])) {
    //     $name = null;
    // } else {
    //     $name = $_GET['name'];
    // }

    $secid = " ";
    if(empty($_GET['secid'])) {
        $secid = null;
    } else {
        $secid = $_GET['secid'];
    }

    $sycode = " ";
    if(empty($_GET['sycode'])) {
        $sycode = null;
    } else {
        $sycode = $_GET['sycode'];
    }

    $term = " ";
    if(empty($_GET['term'])) {
        $term = null;
    } else {
        $term = $_GET['term'];
    }
    
    // $id = $_GET['id'];
    $userdetails = $olenrollment->get_userdata();
    $student = $olenrollment->getStudentName();
    $viewOpenSY = $olenrollment->getOpenSY();
    $courses = $olenrollment->getCourse();
    $sectionname = $olenrollment->getSectionNameonly($secid);
    $sectionsnameonly = $olenrollment->getSectionName($scourse);
    $fees = $olenrollment->viewFee($year, $term, $scourse);
    $schedules = $olenrollment->getScheduleEnroll($scourse, $year, $term, $secid);
    $olenrollment->EnrollStudent($_POST);
    $olenrollment->addAccount($_POST);

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
    <link rel="stylesheet" href="../css/registrar.css">
    <link href="../css/3b-autocomplete.css" rel="stylesheet">
    <script src="../js/3b-autocomplete.js"></script>
    <script>
    window.addEventListener("load", function(){
      suggest.attach({
        target : "user-name",
        url : "searchStudent.php",
        data : { type : "user"  }
      });
    });

    function getStudentId(sid) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else{
            xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange= function(){
            if (this.readyState==4 && this.status==200) {
                document.getElementById('studentid').innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET","getStudentId.php?value="+sid, true);
        xmlhttp.send();
    }

    function showstudentid(sid) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else{
            xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange= function(){
            if (this.readyState==4 && this.status==200) {
                document.getElementById('showstudentid').innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET","showstudentid.php?value="+sid, true);
        xmlhttp.send();
    }

    function spassword(sid) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else{
            xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange= function(){
            if (this.readyState==4 && this.status==200) {
                document.getElementById('spassword').innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET","studentpassword.php?value="+sid, true);
        xmlhttp.send();
    }

    function getStudentName(name) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else{
            xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange= function(){
            if (this.readyState==4 && this.status==200) {
                document.getElementById('studentname').innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET","getStudentName.php?value="+name, true);
        xmlhttp.send();
    }

    function getsectionid(sid) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else{
                xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
            }

            xmlhttp.onreadystatechange= function(){
                if (this.readyState==4 && this.status==200) {
                    document.getElementById('secid').innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET","getsectionid.php?value="+sid, true);
            xmlhttp.send();
            }

        function getSectionName(){
        var hr = new XMLHttpRequest();
        var url = "getSectionName.php";
        var yearlevel = document.getElementById("yearlevel").value;
        var term = document.getElementById("term").value;
        var course_code = document.getElementById("course_code").value;
        var vars = "yearlevel="+yearlevel+"&term="+term+"&course_code="+course_code;
        hr.open("GET", url+"?"+vars, true);
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr.onreadystatechange = function() {
    	    if(hr.readyState == 4 && hr.status == 200) {
    		    var return_data = hr.responseText;
    			document.getElementById("sectionname").innerHTML = return_data;
    	    }
        }
        hr.send(vars);
    }

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
                        <div class="nav_link collapse">
                            <img src="./../images/enrollment.ico" class="nav_icon"></img>
                            <span class="nav_name">Enrollment</span>
                            <img src="./../images/arrow-2.ico" class="collapse_link"></img>
                            <ul class="collapse_menu">
                                <a href="enrollment.php" class="collapse_sublink">Add&nbsp;Enrollment</a>
                                <a href="enrollmentlist.php?sycode=<?= $viewOpenSY['sycode'] ?>" class="collapse_sublink">Enrollment&nbsp;List</a>
                                <a href="unenrolllist.php?sycode=<?= $viewOpenSY['sycode'] ?>" class="collapse_sublink">Unenrollment&nbsp;List</a>
                                <a href="enrollmenthistory.php?sycode=<?= $viewOpenSY['sycode'] ?>" class="collapse_sublink">Enrollment&nbsp;History</a>
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
                                <a href="studentsaccount.php" class="collapse_sublink">Student&nbsp;Account</a>
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
                <h2>Manage Enrollment</h2>
                <div class="search-input">
                    <label>Search</label>
                    <input type="text" id="user-name" class="user-name"  onmouseout="getStudentId(this.value); getStudentName(this.value); showstudentid(this.value); spassword(this.value);" required/>  
                </div>
            </div>
            <div class="search-container">
                <div class="search-option">
                    <label> Year / Term : </label>
                    </div>
                    <input type="text" name="sycode" class = "search-text" value="<?= $viewOpenSY['sycode'] ?>" readonly/>
                
                <form action="enrollment.php?course=<?= $scourse ?>year=<?= $year ?>secid=<?=  $secid ?>" method="GET">
                    <div class="search-option">
                        <label>Course</label>
                        </div>
                        <select name="course" id="course_code" class = "search-text" onchange="getSectionName();">
                            <option disabled selected value> -- Select an option -- </option>
                            <?php foreach($courses as $course) { ?>
                                <option value="<?= $course['course_code'] ?>" <?= ($course['course_code']=="$scourse") ? 'selected' : ' '; ?>><?= $course['course_code'] ?></option>
                            <?php } ?>
                        </select>
                    
                    <div class="search-option">
                        <label>Year Level :</label>
                        </div> 
                        <select name="year" id="yearlevel" class = "search-text" onchange="getSectionName();">
                            <option disabled selected value> -- Select an option -- </option>
                            <option value="1st Year" <?= ($year=="1st Year") ? 'selected' : ' '; ?>>1st Year</option>
                            <option value="2nd Year"<?= ($year=="2nd Year") ? 'selected' : ' '; ?>>2nd Year</option>
                            <option value="3rd Year" <?= ($year=="3rd Year") ? 'selected' : ' '; ?>>3rd Year</option>
                            <option value="4th Year" <?= ($year=="4th Year") ? 'selected' : ' '; ?>>4th Year</option>
                        </select>
                    
                    <div class="search-option">
                        <label>Term :</label> 
                    </div>
                        <input type="text" name="term" class = "search-text" id="term" value="<?= $viewOpenSY['term'] ?>" onchange="getSectionName();" readonly>
                    
                    <div class="search-option">
                        <label>Section :</label>
                    </div>
                        <div id="sectionname" style="display:inline;">
                            <select name="" id="" class = "search-text" onchange="getSectionId(this.value);">
                                <option disabled selected value>-- Select an option --</option>
                                <option value="<?= $sectionname['section_name'] ?>" <?= isset($sectionname['section_name']) ? 'selected' :  ' '; ?>><?= $sectionname['section_name'] ?></option>
                            </select>
                            <input type="hidden" name="secid" value="<?= $secid ?>">
                        </div>
                    
                    <div class="search-option">
                        <input type="submit" class="button-select" value = "Load Data">
                        <div id="secid"> 
                            <input type="hidden" value="">
                        </div>
                    </div>
                    <div class="search-option">
                    <h4>Subject List and Schedule</h4>
                    </div>
                </form>
            </div>
            <div class="student-container">
                <div class="search-option">
                    <label>Student ID : </label>
                </div>
                <div id="showstudentid">
                    <input type="text" name="" class="search-text" value="" readonly required>
                </div>
                <div class="search-option">
                <label>Student Name: </label>
                </div>
                <div id="studentname">
                    <input type="text" name="" class="search-text" value="" readonly required>
                </div>
            </div>

            
            <table class="table">
                <thead>
                    <th>No.</th>
                    <th>Subject Code</th>
                    <th>Subject Title</th>
                    <th>Units</th>
                    <th>Time</th>
                    <th>Day</th>
                    <th>Year Level</th>
                    <th>Section Name</th>
                    <th>Teacher</th>
                </thead>
                <tbody>
                <?php $i = 0; ?>
                <?php $totalAmount = 0; ?> 
                        <?php if(is_array($schedules) || is_object($schedules))  {?>
                        <?php foreach($schedules as $schedule) {?>
                            <?php $i += 1; ?> 
                            <tr>
                            <td data-label="No."><?php echo $i ?></td>  
                                <td><?= $schedule['subject_code']; ?></td>
                                <td><?= $schedule['subject_title']; ?></td>
                                <td><?= $schedule['units'] ?></td>
                                <td><?= $schedule['timefrom']; ?> - <?= $schedule['timeto']; ?></td>
                                <td><?= $schedule['days']; ?></td>
                                <td><?= $schedule['yearlevel']; ?></td>
                                <td><?= $schedule['section_name']; ?></td>
                                <td><?= $schedule['deptname']; ?></td>
                                <?php $totalAmount += $schedule['amount']  ?>
                                <?php } ?>
                        <?php } else { echo " "; }?> 
                            </tr> 
                </tbody>
            </table>
                <?php if(isset($secid)) { ?>
                <form method="POST">
                    <div class="fee-details">
                        <div class="row-details">
                            <div class="text-details">
                                <b> <label> Tuition Fee : </label>
                            </div>
                            <div class="price-details">
                                <?= number_format($totalAmount, 2); ?> </b>
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
                                <?= $fee['amount']; ?></br>
                            </div>
                        </div>
                            <?php $Nfee += $fee['amount']; ?> 
                        <?php } ?>
                        <?php } else { echo ""; }?> 
                        <?php $totalTuition = $totalAmount + $Nfee ?>
                        <!-- <div class="tuition"> -->
                        <div class="row-details">
                            <div class="text-details">
                                <b><label> Total Tuition Fee : </label> 
                            </div>
                            <div class="price-details">
                                <?= number_format($totalTuition, 2); ?></b>
                            </div>
                            <input type="hidden" name="totalFees" id="totalFees" value="<?= $totalTuition; ?>">
                        </div>
                        <div class="row-details">
                        <div class="print-btn-submit">
                        <input type="submit" class="print-btn" name="save" value="Enroll Student" onclick="return confirm('Are you sure you want to enroll this student');">
                        </div>
                            <input type="hidden" name="yearlevel" value="<?= $year ?>">
                            <input type="hidden" name="term" value="<?= $term ?>">
                        </div>          
                        <div id="studentid">
                            <input type="hidden" name="studentid" value="" readonly>
                        </div>
                        <div id="spassword">
                            <input type="hidden" name="password" value="" readonly>
                        </div>
                    </div>
                    <div class="type-details">
                        <select name="feetype" class="print-btn" id="selectoption" onchange="getSelectOption(); getPrelim(); getMidterm(); getPrefinal(); getFinal(); getAmountDue();" required>
                            <option disabled selected value> -- Select an option -- </option>
                            <option value="Full Payment">Full Payment</option>
                            <option value="Installment">Installment</option>
                        </select>
                        <div id="enrollprice">
                            <label></label>
                        </div>
                        <div id="prelim">
                            <label></label>
                        </div>
                        <div id="midterm">
                            <label></label>
                        </div>
                        <div id="prefinal">
                            <label></label>
                        </div>
                        <div id="final">
                            <label></label>
                        </div>
                        <div id="amountdue">
                            <label></label>
                        </div>
                        <input type="hidden" name="sycode" value="<?= $viewOpenSY['sycode'] ?>">
                        <input type="hidden" name="coursecode" value="<?= $scourse ?>">
                        <input type="hidden" name="sectionid" value="<?= $secid ?>">    
                    </div>  
                <div style="margin-bottom:50px;"></div>
                <?php } else { echo " "; }?> 
            </form>
        </div>
    </div>
    <script src="../js/course.js"></script>
</body>
</html>