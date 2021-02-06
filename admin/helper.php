<?php
require_once('../enrollmentclass.php');
$section_name= $_GET["value"];
$sections = $olenrollment->getCourseDesc($section_name);
$olenrollment->addSubject($_POST);

echo "<form method = 'POST' action = ''>";
foreach($sections as $section) { 
    echo "<input type='text' name='course_description' value='".$section['course_description']."'>";
     } 
echo "</form>";
    //echo "<input type='text' value='.$section['section_id'].'>";

?>