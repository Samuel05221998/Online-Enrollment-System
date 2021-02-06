<?php
    require_once('../enrollmentclass.php');
    
    // $id = $_GET['id'];
    $userdetails = $olenrollment->get_userdata();

    if(isset($userdetails)) {
        if($userdetails['position'] != "Registrar") {

            header("Location: ../login.php");
        }
    } else {
        header("Location: ../login.php");
    }

    if(isset($_POST['Delete']))
    {
        $image=$_POST['image'];
        $student_id=$_POST['student_id'];
        $last_name=$_POST['last_name'];
        $first_name=$_POST['first_name'];
        $middle_name=$_POST['middle_name'];
        $suffix_name=$_POST['suffix_name'];
        $address=$_POST['address'];
        $birthdate=$_POST['birthdate'];
        $age=$_POST['age'];
        $gender=$_POST['gender'];
        $weight=$_POST['weight'];
        $height=$_POST['height'];
        $email=$_POST['email'];
        $marital=$_POST['marital'];
        $citizenship=$_POST['citizenship'];
        $mobile_no=$_POST['mobile_no'];
        $guardian=$_POST['guardian'];
        $gdn_mobile_no=$_POST['gdn_mobile_no'];
    }

    $olenrollment->deleteStudent($_POST);
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
                <li><a href="#"><?=$userdetails['fullname']." "."(".$userdetails['position'].")" ?></a></li>    
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
        <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>" enctype ="multipart/form-data" >
            <div class="right-side">
                <div class="main-container">
                    <h2>Manage Student</h2>
                </div>
                 <h1>Are you sure you want to delete this data in the below? </h1>
                <h4>&nbsp;</h4>
                <h3>Student Image</h3>
                <div class="img">
                    <img id="output_image" width="240px" height="210px" src="data:image;base64,<?= $image ?>">
                    </div>
                <h3>Student ID : <?= (isset($student_id)) ? $student_id : ' '; ?></h3>
                <h3>Student Name : <?= (isset($last_name)) ? $last_name. " " .$first_name. " " .$middle_name. " " .$suffix_name : ' '; ?></h3>
                <h4>&nbsp;</h4>
                <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                <div class="opt_btn">
                <?php if(isset($student_id)) { ?>
                    <input type="submit" class="button-opt" name="Yes" value="YES">
                    <input type="hidden" name="student_id" value="<?= (isset($student_id)) ? $student_id : ' '; ?>">
                    <?php } else { ?>
                        <input type="submit" class="button-opt" name="Yes" value="YES" disabled>
                    <?php } ?>
                        <input type="submit" class="button-opt" name="No" value="NO">
                    </form>
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