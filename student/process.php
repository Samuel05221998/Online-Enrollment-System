<?php 
$redirectStr = ''; 
    // Include and initialize database class 
    include_once 'DB.class.php'; 
    $db = new DB; 
 
    // Include and initialize paypal class 
    include_once 'PaypalExpress.class.php'; 
    $paypal = new PaypalExpress;
    
    require_once('../enrollmentclass.php');
     
    // Get payment info from URL 
    $paymentID = $_GET['paymentID']; 
    $token = $_GET['token']; 
    $payerID = $_GET['payerID']; 
    $studentID = $_GET['sid'];
    $sycode = $_GET['sycode'];
    $percent = $_GET['percent'];
    $eid = $_GET['eid'];
    $description = $_GET['desc'];  
     
    // Validate transaction via PayPal API 
    $paymentCheck = $paypal->validate($paymentID, $token, $payerID, $studentID, $sycode, $percent, $eid, $description); 
     
    // If the payment is valid and approved 
    if($paymentCheck && $paymentCheck->state == 'approved'){ 
 
        // Get the transaction data 
        $id = $paymentCheck->id; 
        $state = $paymentCheck->state; 
        $payerFirstName = $paymentCheck->payer->payer_info->first_name; 
        $payerLastName = $paymentCheck->payer->payer_info->last_name; 
        $payerName = $payerFirstName.' '.$payerLastName; 
        $payerEmail = $paymentCheck->payer->payer_info->email; 
        $payerID = $paymentCheck->payer->payer_info->payer_id; 
        $payerCountryCode = $paymentCheck->payer->payer_info->country_code; 
        $paidAmount = $paymentCheck->transactions[0]->amount->details->subtotal; 
        $currency = $paymentCheck->transactions[0]->amount->currency; 
         
        // Get product details 
        $conditions = array( 
            'where' => array('student_id' => $studentID), 
            'return_type' => 'single' 
        ); 
        $productData = $db->getRows('students', $conditions); 
         
        // If payment price is valid 
             
            // Insert transaction data in the database 
            $data = array( 
                'studentid' => $studentID,
                'sycode' => $sycode, 
                'txn_id' => $id, 
                'payment_gross' => $paidAmount, 
                'currency_code' => $currency,
                'description' => $description,
                'payer_id' => $payerID, 
                'payer_name' => $payerName, 
                'payer_email' => $payerEmail, 
                'payer_country' => $payerCountryCode, 
                'payment_status' => $state 
            ); 
            $insert = $db->insert('payments', $data); 
            $olenrollment->updatePercent($percent, $eid);
             
            // Add insert id to the URL 
            $redirectStr = '?id='.$insert; 
    } 
     
    // Redirect to payment status page 
    header("Location:payment-status.php".$redirectStr); 

?>