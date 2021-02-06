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
    $sum = (float)$totalFees * 0.14;
    $final = 0.14;
    echo "<label>Final : </label>";
    echo number_format($sum, 2);
}

?>

<input type='hidden' name='final' id='' value="<?= $final; ?>">

