<?php
require_once('../enrollmentclass.php');
$name= $_GET["value"];
$sectionid = $olenrollment->getSectionIdonly($name);

echo "<form method = 'GET' action = 'scheduling.php'>";

    echo "<input type='hidden' name='secid' value='".$sectionid['section_id']."' readonly>";
      
echo "</form>";
?>
