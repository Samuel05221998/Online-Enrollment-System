<?php
    require_once('../enrollmentclass.php');
    
    // $id = $_GET['id'];
    $userdetails = $olenrollment->get_userdata();
    $olenrollment->addStudent($_POST);
    $courses = $olenrollment->getCourse();
    $students = $olenrollment->getStudents();
    $viewOpenSY = $olenrollment->getOpenSY();

    //$olenrollment->archiveStudent($_POST);
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
    <script type="text/javascript">

function show_confirm()
{
  var r = confirm("Are you sure?");
  if(r == true)
  {
     <?= $olenrollment->archiveStudent($_POST); ?>
     return true;
  } else {
     // do something
     header("list_students.php")
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
                <a href="logout.php" class="nav_link">
                    <img src="./../images/logout.ico" class="nav_icon"></img>
                    <span class="nav_name">Logout</span>
                </a>
            </div>
        </div>
        <div class="right-side">
            <div class="enroll-main-container">
                <h1>Manage Students</h1>
                <a href="addstudent.php" class="button">Add Student</a>
            </div>
            <div class="table-form">
                <table class="table">
                    <thead>
                        <th>No.</th>
                        <th>Image</th>
                        <th>Student ID</th>
                        <th>Full Name</th>
                        <th>Address</th>
                        <th>BirthDate</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>Email</th>
                        <th>Marital</th>
                        <th>Citizenship</th>
                        <th>Mobile No.</th>
                        <th>Guardian Name</th>
                        <th>Guardian Mobile No.</th>
                        <th>Option</th>
                    </thead>
                    <tbody> 
                        <?php $i = 0; ?>
                        <?php if(is_array($students) || is_object($students))  {?>
                        <?php foreach($students as $student) {?>
                            <?php $i += 1; ?>                    
                            <tr>
                                <td data-label="No."><?php echo $i ?></td>  
                                <td data-label="Image"><img height="100px" width="100px" src="data:image;base64,<?= $student['image']; ?>" alt="image"></td>
                                <td><?= $student['student_id']; ?></td>
                                <td data-label="Full Name"> <?= $student['first_name']; ?> <?= $student['middle_name'];?> <?= $student['last_name'];?> <?= $student['suffix_name'];?></td>
                                <td data-label="Address"><?= $student['address']; ?></td>
                                <td data-label="Birthdate"><?= $student['birthdate']; ?></td>
                                <td data-label="Age"><?= $student['age']; ?></td>
                                <td data-label="Gender"><?= $student['gender']; ?></td>
                                <td data-label="Weight"><?= $student['weight']; ?></td>
                                <td data-label="Height"><?= $student['height']; ?></td>
                                <td data-label="Email"><?= $student['email']; ?></td>
                                <td data-label="Marital"><?= $student['marital']; ?></td>
                                <td data-label="Citizenship"><?= $student['citizenship']; ?></td>
                                <td data-label="Mobile Number"><?= $student['mobile_no']; ?></td>
                                <td data-label="Guardian Name"><?= $student['guardian']; ?></td>
                                <td data-label="Guardian Mobile"><?= $student['gdn_mobile_no']; ?></td>
                                <td data-label="Option">
                                    <div class="opt_btn">
                                        <form action="editStudent.php" method="POST">
                                            <input type="submit" class="btn-submit" name="Edit" value="EDIT">
                                            <input type="hidden" name="image" value="<?= $student['image']; ?>">
                                            <input type="hidden" name="student_id" value="<?= $student['student_id']; ?>">
                                            <input type="hidden" name="last_name" value="<?= $student['last_name']; ?>">
                                            <input type="hidden" name="first_name" value="<?= $student['first_name']; ?>">
                                            <input type="hidden" name="middle_name" value="<?= $student['middle_name']; ?>">
                                            <input type="hidden" name="suffix_name" value="<?= $student['suffix_name']; ?>">
                                            <input type="hidden" name="address" value="<?= $student['address']; ?>">
                                            <input type="hidden" name="birthdate" value="<?= $student['birthdate']; ?>">
                                            <input type="hidden" name="age" value="<?= $student['age']; ?>">
                                            <input type="hidden" name="gender" value="<?= $student['gender']; ?>">
                                            <input type="hidden" name="weight" value="<?= $student['weight']; ?>">
                                            <input type="hidden" name="height" value="<?= $student['height']; ?>">
                                            <input type="hidden" name="email" value="<?= $student['email']; ?>">
                                            <input type="hidden" name="marital" value="<?= $student['marital']; ?>">
                                            <input type="hidden" name="citizenship" value="<?= $student['citizenship']; ?>">
                                            <input type="hidden" name="mobile_no" value="<?= $student['mobile_no']; ?>">
                                            <input type="hidden" name="guardian" value="<?= $student['guardian']; ?>">
                                            <input type="hidden" name="gdn_mobile_no" value="<?= $student['gdn_mobile_no']; ?>">
                                            <input type="hidden" name="status" value="<?= $student['status']; ?>">
                                        </form>
                                        <form action="deleteStudent.php" method="POST">
                                            <input type="submit" class="btn-submit" name="Delete" value="DELETE">
                                            <input type="hidden" name="image" value="<?= $student['image']; ?>">
                                            <input type="hidden" name="student_id" value="<?= $student['student_id']; ?>">
                                            <input type="hidden" name="last_name" value="<?= $student['last_name']; ?>">
                                            <input type="hidden" name="first_name" value="<?= $student['first_name']; ?>">
                                            <input type="hidden" name="middle_name" value="<?= $student['middle_name']; ?>">
                                            <input type="hidden" name="suffix_name" value="<?= $student['suffix_name']; ?>">
                                            <input type="hidden" name="address" value="<?= $student['address']; ?>">
                                            <input type="hidden" name="birthdate" value="<?= $student['birthdate']; ?>">
                                            <input type="hidden" name="age" value="<?= $student['age']; ?>">
                                            <input type="hidden" name="gender" value="<?= $student['gender']; ?>">
                                            <input type="hidden" name="weight" value="<?= $student['weight']; ?>">
                                            <input type="hidden" name="height" value="<?= $student['height']; ?>">
                                            <input type="hidden" name="email" value="<?= $student['email']; ?>">
                                            <input type="hidden" name="marital" value="<?= $student['marital']; ?>">
                                            <input type="hidden" name="citizenship" value="<?= $student['citizenship']; ?>">
                                            <input type="hidden" name="mobile_no" value="<?= $student['mobile_no']; ?>">
                                            <input type="hidden" name="guardian" value="<?= $student['guardian']; ?>">
                                            <input type="hidden" name="gdn_mobile_no" value="<?= $student['gdn_mobile_no']; ?>">
                                        </form>
                                        <form action="<?php htmlspecialchars("PHP_SELF"); ?>" method="POST">
                                            <input type="submit" class="btn-submit" name="Archive" value="ARCHIVE" onclick="javascript:return confirm('Are you sure to move in archive?');">
                                            <input type="hidden" name="student_id" value="<?= $student['student_id']; ?>">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php } else { echo "No Data"; }?>
                    </tbody>  
                </table>
            </div>
        </div>
    </div>
    <script src="../js/course.js"></script>
</body>
</html>
