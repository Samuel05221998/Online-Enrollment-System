<?php
require_once('../enrollmentclass.php');
$section_name= $_GET["value"];
$sections = $olenrollment->getSectionId($section_name);
?>

<form method = 'GET' action = 'enrollment.php'>
<?php foreach($sections as $section) {  ?>
    <input type='hidden' name='secid' value="<?= $section['section_id'] ?>" readonly>
<?php } ?> 
</form>