<?php
    require_once('../enrollmentclass.php');
    $userdetails = $olenrollment->get_userdata();
    if(empty($_POST['studentid'])){ 
        header("Location: index.php"); 
    } else {
        $sycode = $_POST['sycode'];
        $studentid = $_POST['studentid'];
        $studentname = $_POST['studentname'];
        $amount = $_POST['amount'];
        $remarks = $_POST['remarks'];
        $enrollmentid = $_POST['enrollmentid'];
        $result = explode('|', $remarks);
        $result0 = $result[0];
        $result1 = $result[1];
    }
     
    // Include and initialize database class 
    include_once 'DB.class.php'; 
    $db = new DB; 
     
    // Include and initialize paypal class 
    include_once 'PaypalExpress.class.php'; 
    $paypal = new PaypalExpress; 
     

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
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
</head>
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
                <a href="logout.php" class="nav_link">
                    <img src="./../images/logout.ico" class="nav_icon"></img>
                    <span class="nav_name">Logout</span>
                </a>
            </div>
        </div>
        <div class="right-side">
            <div class="enroll-main-container">
                <h2>Student ID</h2>
            </div>
            <p>Year/Term : <?= $sycode ?></p>
            <p>Student ID : <?php echo $studentid; ?> </p>
            <p>Price: <?php echo $amount; ?></p>
            <p>Remarks: <?php echo $result1; ?></p>
            <input type="hidden" name="" value="<?= $result0 ?>">
            <input type="hidden" name="" value="<?= $enrollmentid ?>">
            
            <div id="paypal-button"></div>
            
        </div>
    </div>
    <script>
paypal.Button.render({
    env: '<?php echo $paypal->paypalEnv; ?>',
    client: {
        sandbox: '<?php echo $paypal->paypalClientID; ?>',
        production: '<?php echo $paypal->paypalClientID; ?>'
    },
    locale: 'en_US',
    style: {
        size: 'medium',
        color: 'gold',
        shape: 'pill',
    },
    payment: function (data, actions) {
        return actions.payment.create({
            transactions: [{
                amount: {
                    total: '<?php echo $amount; ?>',
                    currency: '<?php echo 'PHP'; ?>'
                },
                description: '<?= $result1.' '.$studentname.' '.$studentid.' For SY '.$sycode ?>'
            }]
      });
    },
    // Execute the payment
    onAuthorize: function (data, actions) {
        return actions.payment.execute()
        .then(function () {
            // Show a confirmation message to the buyer
            //window.alert('Thank you for your purchase!');
            
            // Redirect to the payment process page
            window.location = "process.php?paymentID="+data.paymentID+"&token="+data.paymentToken+"&payerID="+data.payerID+"&sid=<?php echo $studentid; ?>"+"&sycode=<?php echo $sycode; ?>"+"&percent=<?php echo $result0; ?>"+"&eid=<?php echo $enrollmentid; ?>"+"&desc=<?php echo $result1 ?>";
        });
    }
}, '#paypal-button');
</script>
<script src="../js/course.js"></script>
<script src="../js/modal.js"></script>
</body>
</html>