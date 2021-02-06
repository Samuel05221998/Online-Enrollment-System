<?php 
if(!empty($_GET['id'])){ 
    // Include and initialize database class 
    include_once 'DB.class.php'; 
    $db = new DB; 
     
    // Get payment details 
    $conditions = array( 
        'where' => array('id' => $_GET['id']), 
        'return_type' => 'single' 
    ); 
    $paymentData = $db->getRows('payments', $conditions); 
     
    // Get product details 
    $scondition = array( 
        'where' => array('student_id' => $paymentData['studentid']), 
        'return_type' => 'single' 
    ); 
    $productData = $db->getRows('students', $scondition); 
}else{ 
    header("Location: index.php"); 
}
require_once('../enrollmentclass.php');
    
    // $id = $_GET['id'];
    $userdetails = $olenrollment->get_userdata();
    
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
    <link rel = "stylesheet" href = "print.css" media="print" />
    <link rel="stylesheet" href="../css/student.css" media="screen">
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
                <a href="logout.php" class="nav_link">
                    <img src="./../images/logout.ico" class="nav_icon"></img>
                    <span class="nav_name">Logout</span>
                </a>
            </div>
        </div>
        <div class="right-side">
        <h1> Online Enrollment System - Tuition Fee</h1>
        <div class="status">
            <?php if(!empty($paymentData)){ ?>
                <h2 class="success">Your Payment has been Successful!</h2>
                <div class="rows-details">
                    <h3>Payment Information</h3>
                </div>
                <div class="rows-details">
                    <div class="payment-details">
                        <strong>Payment Date:</strong> <?php echo $paymentData['created']; ?>
                    </div>
                    <div class="payment-details">
                        <strong>TXN ID:</strong> <?php echo $paymentData['txn_id']; ?>
                    </div>
                </div>
                <div class="rows-details">
                    <div class="payment-details">
                        <b>Paid Amount:</b> <?php echo $paymentData['payment_gross'].' '.$paymentData['currency_code']; ?>
                    </div>
                    <div class="payment-details">
                        <b>Paid Description:</b> <?php echo $paymentData['description']; ?>
                    </div>
                </div>
                <div class="rows-details">
                    <div class="payment-details">
                        <b>Payment Status:</b> <?php echo $paymentData['payment_status']; ?>
                    </div>
                </div>
                <div class="rows-details">
                    <div class="payment-details">
                        <b>Payer Name:</b> <?php echo $paymentData['payer_name']; ?>
                    </div>
                    <div class="payment-details">
                        <b>Payer Email:</b> <?php echo $paymentData['payer_email']; ?>
                    </div>
                </div>
                <div class="rows-details">
                    <h3>Student Information</h3>
                </div>
                <div class="rows-details">
                    <div class="payment-details">
                        <b>Student ID:</b> <?php echo $productData['student_id']; ?>
                    </div>
                    <div class="payment-details">
                        <b>Name:</b> <?php echo $productData['studentname']; ?>
                    </div>
                </div>
                <div class="rows-details">
                <div class="payment-details">
                    <b>School Year: </b><?php echo $paymentData['sycode']; ?>
                </div>
                </div>
            <?php }else{ ?>
                <h1 class="error">Your Payment has Failed</h1>
            <?php } ?>
        </div>
        <a href="index.php" class="btn-link" id="print-btn">Back to Home</a>
        <button onclick="window.print()" class="print-btn" id="print-btn">Save and Print</button>
    </div>
    <script src="../js/course.js"></script>
</body>
</html>