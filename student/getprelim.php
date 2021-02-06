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
    $prelim = 0.16;
    $sum = (float)$totalFees * 0.16;
    echo "<label>Prelim : </label>";
    echo number_format($sum, 2);
}

$olenrollment->EnrollStudent($_POST);
?>

<form action="" method="POST">
<input type='hidden' name='prelim' id='' value="<?= $prelim; ?>">
</form>

