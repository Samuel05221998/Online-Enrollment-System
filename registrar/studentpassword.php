<?php
require_once('../enrollmentclass.php');
$sid= $_GET["value"];
$students = $olenrollment->searchStudent($sid);
$olenrollment->EnrollStudent($_POST);
$date = date_create($students['birthdate']);

?>
<form action="" method="POST">

<input type="hidden" name="password" value="<?= $students['last_name']. "" .date_format($date, "Y")  ?>" readonly>

</form>