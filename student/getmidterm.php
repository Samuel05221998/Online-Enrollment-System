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
    echo "<label> </label>";
} else if($selectoption=="Installment") {
    $midterm = 0.16;
    $sum = (float)$totalFees * 0.16;
    echo "<label>Midterm : </label>";
    echo number_format($sum, 2);
}

?>

<input type='hidden' name='midterm' id='' value="<?= $midterm; ?>">

