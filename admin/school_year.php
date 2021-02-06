<?php
    require_once('../enrollmentclass.php');
    
    // $id = $_GET['id'];
    $userdetails = $olenrollment->get_userdata();
    $selectallsy = $olenrollment->getSchoolYear();
    $viewaccesses = $olenrollment->getAccess();
    $olenrollment->closeSY($_POST);
    $olenrollment->openSY($_POST);
    // $olenrollment->closeStatus2($_POST);
    $olenrollment->openSY($_POST);
    $olenrollment->addSY($_POST);


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
    <script type="text/javascript">
        function show_confirm()
        {
            var r = confirm("Are you sure to open this school year?");
            if(r == true)
            {
                <?=  $olenrollment->closeStatus($_POST); ?>
                return true;
            } else {
                return false;
            }
        }

        function show_confirm1()
        {
            var r = confirm("Are you sure to close this school year?");
            if(r == true)
            {
                //  $olenrollment->closeStatus($_POST); ?>
                <?= $olenrollment->openSY($_POST); ?>
                $olenrollment->closeStatus2($_POST);
                return true;
            } else {
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
                <h2>Manage School Year</h2>
                <button class="modal-btn">ADD NEW</button>
            </div>
            <form method = "POST" action = "<?php htmlspecialchars("PHP_SELF"); ?>">
                <div class = "modal-bg">
                    <div class = "modal">
                        <h2>School Year</h2>
                        <label for="name">Year From:</label>
                        <input type = "text" name = "year1" autocomplete="off">
                        <label for="name">Year To:</label>
                        <input type = "text" name = "year2" autocomplete="off">
                        <label for="name">Term</label>
                        <select name="term" id="">
                            <option value="1st Term">1st Term</option>
                            <option value="2nd Term">2nd Term</option>
                        </select>
                        <button class = "sub" name = "btnSave">SAVE</button>
                        <span class = "modal-close">X</span>
                    </div>
                </div>
            </form>    
            <table class="table">
                <thead>
                    <th>No.</th>
                    <th>SYCode</th>
                    <th>Year</th>
                    <th>Term</th>
                    <th>Status</th>
                    <th>Option</th>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                        <?php foreach($selectallsy as $schoolyear) { ?>
                            <?php $i += 1; ?>
                            <tr>
                                <td data-label="No."><?php echo $i ?></td>
                                <td data-label="SYCode"><?= $schoolyear['sycode'] ?></td>
                                <td data-label="Year"><?= $schoolyear['year1']."-".$schoolyear['year2'] ?></td>
                                <td data-label="term"><?= $schoolyear['term'] ?></td>
                                <td data-label="status"><?= $schoolyear['status'] ?></td>
                                <td data-label="Option">
                                    <div class="opt_btn">
                                        <form method="POST">
                                            <input type="submit" name="colOpen" value="OPEN" onclick="javascript:return confirm('Are you sure to open this school year?');">
                                            <input type="hidden" name="openAY" value="<?= $schoolyear['sycode'] ?>">
                                        </form>
                                        <form method="POST">
                                            <input type="submit" name="colClose" value="CLOSE" onclick="javascript:return confirm('Are you sure to close this school year?');">
                                            <input type="hidden" name="closeAY" value="<?= $schoolyear['sycode'] ?>">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="../js/course.js"></script>
    <script src="../js/modal.js"></script>
</body>
</html>