<?php
    require_once('enrollmentclass.php');

    $olenrollment->onlineRegister($_POST);
    $generatekey = $olenrollment->generateKey();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <title>Online Enrollment System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <div class="logo">
            <h4>Online Enrollment System</h4>
        </div>
        <ul class="nav-links">
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>
                <a href="about.php">About</a>
            </li>
            <li>
                <a href="enroll_now.php">Online Registration</a>
            </li>
            <li>
                <a href="login.php">Login</a>
            </li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>
    <section id="showcase">
        <div class="container">
            <h1>Online Enrollment System: A Dynamic Decision-Making Tool For Tertiary School Year 2020-2021</h1>
        </div>
    </section>
    <section class="enroll">
        <div class="enroll-title">
            <h2>please fill up the form</h2>
        </div>
        <form method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>" enctype ="multipart/form-data">
            <div class="img">
                <img id="output_image" width="240px" height="210px">
            </div>
            </div>
            <input type="hidden" name="student_id" id="" value="<?= $generatekey ?>">
            <div class="img">
                    <label><b>Profile Photo</b></label>
            </div>
            <div class="img">
                    <input type="file" name="image" accept="image/*" onchange="display(event)" required>
            </div>
                    <!-- <input type = "button" name = "upload"  value ="Upload" onClick = "document.getElementById('image').click()" /><br><br> -->
            
            <div style="width:100%; height:20%; background-color:#ddd; padding: 10px; margin:20px 0px;">Student Information</div>
            <div class="enroll-center">
                <article class="enroll-form">
                    <div class="text-container">
                        <input type="text" name="lname" class="enroll-text" required>
                    </div>
                    <h3>Last Name</h3>
                </article>
                <article class="enroll-form">
                    <div class="text-container">
                        <input type="text" name="fname" class="enroll-text" required>
                    </div>
                    <h3>First Name</h3>
                </article>
                <article class="enroll-form">
                    <div class="text-container">
                        <input type="text" name="mname" class="enroll-text">
                    </div>
                    <h3>Middle Name</h3>
                </article>
                <article class="enroll-form">
                    <div class="text-container">
                        <input type="text" name="sfxname" class="enroll-text">
                    </div>
                    <h3>Sufflix Name</h3>
                </article>
            </div>
            <div class="enroll-center">
                <article class="enroll-form">
                    <div class="text-container">
                        <input type="text" name="address" class="enroll-text" required>
                    </div>
                    <h3>Current Address</h3>
                </article>
            </div>
            <div class="enroll-center">
                <article class="enroll-form">
                    <div class="text-container">
                        <input type="date" name="birthdate" id="" class="enroll-text" required>
                    </div>
                    <h3>Date of Birth</h3>
                </article>
                <article class="enroll-form">
                    <div class="text-container">
                        <input type="text" name="age" class="enroll-text">
                    </div>
                    <h3>Age</h3>
                </article>
                <article class="enroll-form">
                    <div class="text-container">
                        <select name = "gender" class="enroll-text" required>
                            <option  disabled selected value> -- Select an option -- </option>
                            <option value = "Male"> Male </option>
                            <option value = "Female"> Female </option>
                        </select>
                    </div>
                    <h3>Gender</h3>
                </article>
                <article class="enroll-form">
                    <div class="text-container">
                        <input type="text" name="weight" class="enroll-text" required>
                    </div>
                    <h3>Weight</h3>
                </article>
                <article class="enroll-form">
                    <div class="text-container">
                        <input type="text" name="height" class="enroll-text" required>
                    </div>
                    <h3>Height</h3>
                </article>
                <article class="enroll-form">
                    <div class="text-container">
                        <input type="text" name="email" class="enroll-text" required>
                    </div>
                    <h3>Email</h3>
                </article>
                <article class="enroll-form">
                    <div class="text-container">
                        <select name="marital" class="enroll-text" required>
                            <option  disabled selected value> -- Select an option -- </option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>
                    <h3>Marital Status</h3>
                </article>
                <article class="enroll-form">
                    <div class="text-container">
                        <input type="text" name="citizenship" class="enroll-text" required>
                    </div>
                    <h3>Citizenship</h3>
                </article>
                <article class="enroll-form">
                    <div class="text-container">
                        <input type="text" name="mobile_no" class="enroll-text" required>
                    </div>
                    <h3>Mobile No./Tel.No</h3>
                </article>
            </div>
            <div style="width:100%; height:20%; background-color:#ddd; padding: 10px; margin-bottom:20px;">Parent Information</div>
            <div class="enroll-center">
                <article class="form-form">
                    <div class="text-container">
                    <input type="text" name="guardian" class="enroll-text" required>
                    </div>
                    <h3>Guardian Fullname</h3>
                </article>
                <article class="enroll-form">
                    <div class="text-container">
                    <input type="text" name="gdnmobile" class="enroll-text" required>
                    </div>
                    <h3>Guardian Mobile No./Tel.No</h3>
                </article>
            </div>
    </section>  
    <div class="enroll-button">
        <div class="button-container">
                <input type="submit" name="Save" class="banner-btn" value="Enroll" onclick="return confirm('Are you sure you want to apply online');">
        </div>
        </form>
    </div>
    <footer id="main-footer">
        <p>Copyright &copy; 2020 Online Enrollment System</p>
    </footer>
    <script src="js/index.js"></script>
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