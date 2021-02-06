<?php
require_once('../enrollmentclass.php');
$section_name= $_GET["value"];
$sectionsid = $olenrollment->getSectionId($section_name);
$olenrollment->addSchedule($_POST);

echo "<form method = 'POST' action = ''>";
foreach($sectionsid as $sectionid) { 
    echo "<input type='hidden' name='sectionid' value='".$sectionid['section_id']."' readonly>";
     } 
echo "</form>";
?>