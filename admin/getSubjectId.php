<?php
require_once('../enrollmentclass.php');
$subject_code= $_GET["value"];
$subjectnames = $olenrollment->getSubjectName($subject_code);
$olenrollment->addSchedule($_POST);

echo "<form method = 'POST' action = ''>";
foreach($subjectnames as $subjectname) { 
    echo "<input type='hidden' name='subjectid' value='".$subjectname['id']."' readonly>";
     } 
echo "</form>";
?>
