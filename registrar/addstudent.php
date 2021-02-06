<?php
    require_once('../enrollmentclass.php');
    
    // $id = $_GET['id'];
    $userdetails = $olenrollment->get_userdata();
    $courses = $olenrollment->getCourse();
    $viewOpenSY = $olenrollment->getOpenSY();
    $generatekey = $olenrollment->generateKey();
     $olenrollment->addStudent($_POST);
    

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
</head>
<body>
    <header>
        <div class="logo">
            <h4>Online Enrollment System</h4>
        </div>
        <ul class="nav-links">
            <li>
                <li><a href="#"><?=$userdetails['deptname'] ?> (<?=$userdetails['position'] ?>)</a></li>    
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
        <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>" enctype ="multipart/form-data">
            <div class="right-side">
                <div class="main-container">
                    <h1>Adding Student</h1>
                        <input type="hidden" name="student_id" id="" value="<?= $generatekey ?>">
                    <!-- <h2>Course</h2>
                    <select name="" id="">
                        <option> ---------- </option>
                        // foreach($courses as $course) 
                        <option value=" $course'course_code']; ?>">$course'course_code'; </option>
                        // } ?>
                    </select> -->
                </div>
                <section class="form">
                    <div class="form-title">
                        <h2>Student Registration</h2>
                    </div>
                </section>
                <div class="img">
                    <img id="output_image" width="240px" height="210px">
                </div>
                        <label><b>Profile Photo</b></label><br>
                        <input type="file" name="image" accept="image/*" onchange="display(event)" required>
                        <!-- <input type = "button" name = "upload"  value ="Upload" onClick = "document.getElementById('image').click()" /><br><br> -->
                <div style="width:100%; height:20%; background-color:#ddd; padding: 10px; margin:20px 0px;">Student Information</div>
                <div class="form-center">
                    <article class="form-form">
                        <div class="text-container">
                            <input type="text" name="lname" class="form-text" required>
                        </div>
                        <h3>Last Name</h3>
                    </article>
                    <article class="form-form">
                        <div class="text-container">
                            <input type="text" name="fname" class="form-text" required>
                        </div>
                        <h3>First Name</h3>
                    </article>
                    <article class="form-form">
                        <div class="text-container">
                            <input type="text" name="mname" class="form-text">
                        </div>
                        <h3>Middle Name</h3>
                    </article>
                    <article class="form-form">
                        <div class="text-container">
                            <input type="text" name="sfxname" class="form-text">
                        </div>
                        <h3>Sufflix Name</h3>
                    </article>
                </div>
                <div class="form-center">
                    <article class="form-form">
                        <div class="text-container">
                            <input type="text" name="address" class="form-text" required>
                        </div>
                        <h3>Current Address</h3>
                    </article>
                </div>
                <div class="form-center">
                    <article class="form-form">
                        <div class="text-container">
                            <input type="date" name="birthdate" id="" class="form-text" required>
                        </div>
                        <h3>Date of Birth</h3>
                    </article>
                    <article class="form-form">
                        <div class="text-container">
                            <input type="text" name="age" class="form-text">
                        </div>
                        <h3>Age</h3>
                    </article>
                    <article class="form-form">
                        <div class="text-container">
                            <select name = "gender" class="form-text" required>
                                <option  disabled selected value> -- Select an option -- </option>
                                <option value = "Male"> Male </option>
                                <option value = "Female"> Female </option>
                            </select>
                        </div>
                        <h3>Gender</h3>
                    </article>
                    <article class="form-form">
                        <div class="text-container">
                            <input type="text" name="weight" class="form-text" required>
                        </div>
                        <h3>Weight</h3>
                    </article>
                    <article class="form-form">
                        <div class="text-container">
                            <input type="text" name="height" class="form-text" required>
                        </div>
                        <h3>Height</h3>
                    </article>
                    <article class="form-form">
                        <div class="text-container">
                            <input type="text" name="email" class="form-text" required>
                        </div>
                        <h3>Email</h3>
                    </article>
                    <article class="form-form">
                        <div class="text-container">
                            <select name="marital" class="form-text" required>
                                <option  disabled selected value> -- Select an option -- </option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                        <h3>Marital Status</h3>
                    </article>
                    <article class="form-form">
                        <div class="text-container">
                            <input type="text" name="citizenship" class="form-text" required>
                        </div>
                        <h3>Citizenship</h3>
                    </article>
                    <article class="form-form">
                        <div class="text-container">
                            <input type="text" name="mobile_no" class="form-text" required>
                        </div>
                        <h3>Mobile No./Tel.No</h3>
                    </article>
                </div>
                <div style="width:100%; height:20%; background-color:#ddd; padding: 10px; margin-bottom:20px;">Parent Information</div>
                <div class="form-center">
                    <article class="form-form">
                        <div class="text-container">
                        <input type="text" name="guardian" class="form-text" required>
                        </div>
                        <h3>Guardian Fullname</h3>
                    </article>
                    <article class="form-form">
                        <div class="text-container">
                        <input type="text" name="gdnmobile" class="form-text" required>
                        </div>
                        <h3>Guardian Mobile No./Tel.No</h3>
                    </article>
                </div>
                <div style="margin-top:30px;"></div>
                <div class="form-center">
                    <article class="form-form">
                        <div class="text-container">
                            <input type="submit" name="submit" class="form-text" value="Submit" onclick="return confirm('Are you sure to add this student ?');">
                        </div>
                    </article>
                </div>
            </div>
        </form>  
        <div style="margin-top:30px;"></div>  
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modal.js"></script>
<script type='text/javascript'>
function display(event) 
{
 var see = new FileReader();
 see.onload = function()
 {
  var outimg = document.getElementById('output_image');
  outimg.src = see.result;
 }
 see.readAsDataURL(event.target.files[0]);
}
</script>
</body>
</html>