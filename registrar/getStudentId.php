<?php
require_once('../enrollmentclass.php');
$sid= $_GET["value"];
$students = $olenrollment->searchStudent($sid);
$olenrollment->EnrollStudent($_POST);


?>
<form action="" method="POST">

<input type="hidden" name="studentid" value="<?= $students['student_id'] ?>" readonly>

</form>