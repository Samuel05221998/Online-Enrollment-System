<?php
    require_once('../enrollmentclass.php');
    
    // $id = $_GET['id'];

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

    $term = " ";
    if(empty($_GET['term'])) {
        $term = null;
    } else {
        $term = $_GET['term'];
    }

    $secid = " ";
    if(empty($_GET['secid'])) {
        $secid = null;
    } else {
        $secid = $_GET['secid'];
    }

    $userdetails = $olenrollment->get_userdata();
    $viewaccesses = $olenrollment->getAccess();
    $programs = $olenrollment->getCourse_Code();
    $courses = $olenrollment->getCourse();
    $teachers = $olenrollment->getTeachersName();
    $olenrollment->addSchedule($_POST);
    $sectionsnameonly = $olenrollment->getSectionName($scourse);
    $sectionname = $olenrollment->getSectionNameonly($secid);
    $schedules = $olenrollment->getSchedule($scourse, $year, $term, $secid);

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
            <?= $olenrollment->deleteSchedule($_POST); ?>
            return true;
        } else {
            return false;
        }
        }

        function getSectionName(){
        var hr = new XMLHttpRequest();
        var url = "getsectionname.php";
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

    function getSubjectCode(){
        var hr = new XMLHttpRequest();
        var url = "getsubjectcode.php";
        var yearlevel = document.getElementById("yearlevel").value;
        var term = document.getElementById("term").value;
        var course_code = document.getElementById("course_code").value;
        var vars = "yearlevel="+yearlevel+"&term="+term+"&course_code="+course_code;
        hr.open("GET", url+"?"+vars, true);
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr.onreadystatechange = function() {
    	    if(hr.readyState == 4 && hr.status == 200) {
    		    var return_data = hr.responseText;
    			document.getElementById("subjectcode").innerHTML = return_data;
    	    }
        }
        hr.send(vars);
    }

    function LoadSectionName(){
        var loadhr = new XMLHttpRequest();
        var loadurl = "loadsectionname.php";
        var loadyearlevel = document.getElementById("loadyearlevel").value;
        var loadterm = document.getElementById("loadterm").value;
        var loadcourse_code = document.getElementById("loadcourse_code").value;
        var loadvars = "loadyearlevel="+loadyearlevel+"&loadterm="+loadterm+"&loadcourse_code="+loadcourse_code;
        loadhr.open("GET", loadurl+"?"+loadvars, true);
        loadhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        loadhr.onreadystatechange = function() {
    	    if(loadhr.readyState == 4 && loadhr.status == 200) {
    		    var return_data = loadhr.responseText;
    			document.getElementById("loadsectionname").innerHTML = return_data;
    	    }
        }
        loadhr.send(loadvars);
    }

    function getSectionId(id) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else{
                xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
            }

            xmlhttp.onreadystatechange= function(){
                if (this.readyState==4 && this.status==200) {
                    document.getElementById('sectionid').innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET","getsectionid.php?value="+id, true);
            xmlhttp.send();
            }

        function getSubjTitle(title) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else{
            xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange= function(){
            if (this.readyState==4 && this.status==200) {
                document.getElementById('subjtitle').innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET","getSubjTitle.php?value="+title, true);
        xmlhttp.send();
        }

        function getSubjUnits(units) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else{
                xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange= function(){
                if (this.readyState==4 && this.status==200) {
                    document.getElementById('units').innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET","getUnits.php?value="+units, true);
            xmlhttp.send();
        }

        function getTeacherId(name) {
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
            xmlhttp.open("GET","getTeacherId.php?value="+name, true);
            xmlhttp.send();
        }

        function getSubjectId(code) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else{
                xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange= function(){
                if (this.readyState==4 && this.status==200) {
                    document.getElementById('subid').innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET","getSubjectId.php?value="+code, true);
            xmlhttp.send();
        }

        function urlSectionId(sid) {
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
            xmlhttp.open("GET","urlsectionid.php?value="+sid, true);
            xmlhttp.send();
            }

            function getCourse(course) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else{
                xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
            }

            xmlhttp.onreadystatechange= function(){
                if (this.readyState==4 && this.status==200) {
                    document.getElementById('sectionname').innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET","getsectionname.php?course="+course, true);
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
                <h2>Scheduling</h2>
                <button class="team-modal-btn">Add Schedule</button>
            </div>
            <form method = "POST" action = "<?php htmlspecialchars("PHP_SELF"); ?>">
                    <div class = "team-modal-bg">
                        <div class = "team-modal">
                            <h2>Adding Schedule</h2>
                            <div class="team-row">
                                <label>Course : </label>
                                <select name="course_code" id="course_code" onchange="getSectionName(); getSubjectCode();">
                                    <option disabled selected value> -- Select an option -- </option>
                                    <?php foreach($courses as $course) { ?>
                                    <option value="<?= $course['course_code'] ?>"><?= $course['course_code'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="team-row">
                            <label>Year Level :</label> 
                        <select name="year" id="yearlevel" onchange="getSectionName(); getSubjectCode();">
                            <option disabled selected value> -- Select an option -- </option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                        </div>
                        <div class="team-row">
                        <label>Term :</label> 
                        <select name="term" id="term" onchange="getSectionName(); getSubjectCode();">
                            <option disabled selected value> -- Select an option -- </option>
                            <option value="1st Term">1st Term</option>
                            <option value="2nd Term">2nd Term</option>
                        </select>
                        </div>
                            <div class="team-row">
                                <label>Section Name : </label>
                                    <div id="sectionname">
                                    <select name="" id="">
                                    <option disabled selected value>-- Select an option --</option>
                                    </select>
                                    </div>
                             </div>
                            <div class="team-row">
                                <label>Subject Code : </label>
                                <div id="subjectcode">
                                    <select name="" id="">
                                        <option disabled selected value>-- Select an option --</option>   
                                    </select>
                                </div>
                            </div>
                            <div class="team-row">
                                <label>Subject Title : </label>
                                <div id="subjtitle">
                                    <input type="text" name="" id="" value="" readonly>
                                </div>
                            </div>
                            <div class="team-row">
                                <label>Units : </label>
                                <div id="units">
                                    <input type="text" name="" id="" value="" readonly>
                                </div>
                            </div>
                            <div class="team-row">
                                <label> Days : </label>
                                <div class="addcheckbox-option">
                                    <input type="checkbox" name="day[]" id="" class="chkOption" value="MON">MON</br>
                                    <input type="checkbox" name="day[]" id="" class="chkOption" value="TUE">TUE</br>
                                    <input type="checkbox" name="day[]" id="" class="chkOption" value="WED">WED</br>
                                    <input type="checkbox" name="day[]" id="" class="chkOption" value="THU">THU</br>
                                    <input type="checkbox" name="day[]" id="" class="chkOption" value="FRI">FRI</br>
                                    <input type="checkbox" name="day[]" id="" class="chkOption" value="SAT">SAT</br>
                                </div>
                            </div>
                            <div class="team-row">
                                <label> Time[From-To] : </label>
                                <div class="time-container">
                                    <input type = "time" name = "timefrom" class="time-input" autocomplete="off">
                                    <input type = "time" name = "timeto" class="time-input" autocomplete="off">
                                </div>
                            </div>
                            <div class="team-row">
                                <label>Teacher ID : </label>
                                <div id="teacherid">
                                    <input type="text" name="" id="" value="" readonly>
                                </div>
                            </div>
                            <div class="team-row">
                                <label> Teacher Name : </label>
                                <select name="" id="" onchange="getTeacherId(this.value);">
                                    <option disabled selected value> -- Select an option -- </option>
                                    <?php foreach($teachers as $teacher) { ?>
                                            <option value="<?= $teacher['deptname']; ?>"><?= $teacher['deptname']; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="team-button-form">
                                <button class = "sub" name = "Save">Save </button>
                            </div>
                                <div id="subid">
                                    <input type="hidden" name="" id="" value="" readonly>
                                </div>
                            
                            <span class = "team-modal-close">X</span>
                        </div>
                    </div>
                </form> 
          
                <div class="select-option">
                    <form method="GET" action="scheduling.php?course=<?= $scourse ?>secid=<?=  $secid ?>">
                        <label>Course : </label>
                            <select name="course" id="loadcourse_code" onchange="LoadSectionName();">
                                <option disabled selected value> -- Select an option -- </option>
                                <?php foreach($courses as $course) { ?>
                                <option value="<?= $course['course_code'] ?>" <?= ($course['course_code']==$scourse) ? 'selected' : ' '; ?>><?= $course['course_code'] ?></option>
                                <?php } ?>
                            </select>
                        <label>Year Level :</label> 
                        <select name="year" id="loadyearlevel" onchange="LoadSectionName();">
                            <option disabled selected value> -- Select an option -- </option>
                            <option value="1st Year" <?= ($year=="1st Year") ? 'selected' : ' '; ?>>1st Year</option>
                            <option value="2nd Year"<?= ($year=="2nd Year") ? 'selected' : ' '; ?>>2nd Year</option>
                            <option value="3rd Year" <?= ($year=="3rd Year") ? 'selected' : ' '; ?>>3rd Year</option>
                            <option value="4th Year" <?= ($year=="4th Year") ? 'selected' : ' '; ?>>4th Year</option>
                        </select>
                        <label>Term :</label> 
                        <select name="term" id="loadterm" onchange="LoadSectionName();">
                            <option disabled selected value> -- Select an option -- </option>
                            <option value="1st Term" <?= ($term=="1st Term") ? 'selected' : ' '; ?>>1st Term</option>
                            <option value="2nd Term"<?= ($term=="2nd Term") ? 'selected' : ' '; ?>>2nd Term</option>
                        </select>
                        <label>Section :</label>
                        <div id="loadsectionname" style="display:inline;">
                            <select name="" id="" onchange="getSectionId(this.value);">
                            <option disabled selected value>-- Select an option --</option>
                            <option value="<?= $sectionname['section_name'] ?>" <?= isset($sectionname['section_name']) ? 'selected' :  ' '; ?>><?= $sectionname['section_name'] ?></option>
                            </select>
                            <input type="hidden" name="secid" value="<?= $secid ?>">
                        </div>
                        <input type="submit" class="button-select" value = "Load Data">
                        <div id="secid"> 
                        <input type="hidden" value="">
                        </div>
                    </form>
                </div>
                <table class="table" <?= (!isset($scourse) ? 'hidden' : '') ?>>
                    <thead>
                        <th>No.</th>
                        <th>Subject Code</th>
                        <th>Subject Title</th>
                        <th>Time</th>
                        <th>Day</th>
                        <th>Year Level</th>
                        <th>Section Name</th>
                        <th>Teacher</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                        <?php if(is_array($schedules) || is_object($schedules))  {?>
                        <?php foreach($schedules as $schedule) {?>
                            <?php $i += 1; ?>       
                            <tr>
                            <td data-label="No."><?php echo $i ?></td>  
                                <td><?= $schedule['subject_code']; ?></td>
                                <td><?= $schedule['subject_title']; ?></td>
                                <td><?= date('h:i A',strtotime($schedule['timefrom'])); ?> - <?= date('h:i A',strtotime($schedule['timeto'])); ?></td>
                                <td><?= $schedule['days']; ?></td>
                                <td><?= $schedule['yearlevel']; ?></td>
                                <td><?= $schedule['section_name']; ?></td>
                                <td><?= $schedule['deptname']; ?></td>
                                <td>
                                    <div class="opt_btn">
                                        <form action="editSchedule.php" method="POST">
                                            <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                            <input type="hidden" name="coursecode" id="" value="<?= $schedule['course_code'] ?>">
                                            <input type="hidden" name="term" id="" value="<?= $schedule['term'] ?>">
                                            <input type="hidden" name="sectionid" id="" value="<?= $schedule['sectionid'] ?>">
                                            <input type="hidden" name="id" id="" value="<?= $schedule['id']; ?>">
                                            <input type="hidden" name="subject_code" id="" value="<?= $schedule['subject_code']; ?>">
                                            <input type="hidden" name="subject_title" id="" value="<?= $schedule['subject_title']; ?>">
                                            <input type="hidden" name="timefrom" id="" value="<?= $schedule['timefrom']; ?>">
                                            <input type="hidden" name="timeto" id="" value="<?= $schedule['timeto']; ?>">
                                            <input type="hidden" name="days" id="" value="<?= $schedule['days']; ?>">
                                            <input type="hidden" name="yearlevel" id="" value="<?= $schedule['yearlevel']; ?>">
                                            <input type="hidden" name="section_name" id="" value="<?= $schedule['section_name']; ?>">
                                            <input type="hidden" name="teacherid" id="" value="<?= $schedule['teacherid']; ?>">
                                            <input type="hidden" name="deptname" id="" value="<?= $schedule['deptname']; ?>">
                                        </form>
                                        <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                                            <input type="submit" class="btn-submit" name="Delete" value="Delete" onclick="javascript:return confirm('Are you sure to Delete this <?= $schedule['subject_code']; ?> ?');">
                                            <input type="hidden" name="id" id="" value="<?= $schedule['id']; ?>">
                                            <input type="hidden" name="course" value="<?= $scourse ?>">
                                            <input type="hidden" name="yearlevel" id="" value="<?= $schedule['yearlevel']; ?>">
                                            <input type="hidden" name="term" id="" value="<?= $schedule['term']; ?>">
                                            <input type="hidden" name="sectionid" id="" value="<?= $secid ?>">
                                        </form>
                                    </div>
                                </td>
                            </tr>  
                            <?php } ?>
                        <?php } else { echo ""; }?>           
                    </tbody>
                </table>
        </div>
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modalDept.js"></script>
</body>
</html>