<?php
require_once('../enrollmentclass.php');

$totalFees = " ";
if(empty($_GET['totalFees'])) {
    $totalFees = null;
} else {
    $totalFees = $_GET['totalFees'];
}

$sum = 0;

$selectoption = " ";
if(empty($_GET['selectoption'])) {
    $selectoption = null;
} else {
    $selectoption = $_GET['selectoption'];
}

if($selectoption=="Full Payment") {
    $sum = (float)$totalFees * 0.9;
    echo "<b><label>Amount Due : </label>";
    echo number_format($sum, 2);
    echo "</b>";
} else if($selectoption=="Installment") {
    $sum = (float)$totalFees;
    echo "<b><label>Amount Due : </label>";
    echo number_format($sum, 2);
    echo "</b>";
}

?>

