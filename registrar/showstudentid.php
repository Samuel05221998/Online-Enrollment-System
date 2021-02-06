<?php
require_once('../enrollmentclass.php');
$sid= $_GET["value"];
$students = $olenrollment->searchStudent($sid);

?>
<input type="text" name="studentid" class="search-text" value="<?= $students['student_id'] ?>" readonly required>
