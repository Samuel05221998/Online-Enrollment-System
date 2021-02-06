<?php
require_once('../enrollmentclass.php');
$totalTuition= $_GET["totalTuition"];
$selectpayment = $_GET['selectpayment'];
$result = explode('|',$selectpayment);
$result1 = $result[0];
?>
<form action="" method="POST">
<?php $compute = $totalTuition * $result1; ?>
<?php $computed = number_format($compute,2); ?>
<input type="text" name="amount" value="<?= $computed ?>" readonly>

</form>