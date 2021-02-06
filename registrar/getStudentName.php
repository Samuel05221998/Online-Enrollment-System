<?php
require_once('../enrollmentclass.php');
$sid= $_GET["value"];
$students = $olenrollment->searchStudent($sid);

echo "<form method = 'POST' action = ''>";


    echo "<input type='text' name='course_description' class='search-text' value='".$students['studentname']."' readonly required>";

echo "</form>";
?>
