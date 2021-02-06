<?php
require_once('../enrollmentclass.php');
$subject_code= $_GET["value"];
$subjectnames = $olenrollment->getSubjectName($subject_code);

echo "<form method = 'POST' action = ''>";
foreach($subjectnames as $subjectname) { 
    echo "<input type='text' name='course_description' value='".$subjectname['subject_title']."' readonly>";
     } 
echo "</form>";
?>
