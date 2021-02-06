<?php
require_once('../enrollmentclass.php');
$last_name= $_GET["value"];
$teachers = $olenrollment->getTeacherId($last_name);
$olenrollment->addSchedule($_POST);

echo "<form method = 'POST' action = ''>";
foreach($teachers as $teacher) { 
    echo "<input type='text' name='teacherid' value='".$teacher['dept_id']."' readonly>";
     } 
echo "</form>";
?>