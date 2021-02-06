<?php
require_once('../enrollmentclass.php');

$loadcourse_code = " ";
if(empty($_GET['loadcourse_code'])) {
    $loadcourse_code = null;
} else {
    $loadcourse_code = $_GET['loadcourse_code'];
}

$loadyearlevel = " ";
if(empty($_GET['loadyearlevel'])) {
    $loadyearlevel = null;
} else {
    $loadyearlevel = $_GET['loadyearlevel'];
}

$loadterm = " ";
if(empty($_GET['loadterm'])) {
    $loadterm = null;
} else {
    $loadterm = $_GET['loadterm'];
}

$sections = $olenrollment->getSectionNameYT($loadyearlevel,$loadterm,$loadcourse_code);
?>

<form method = 'POST' action = ''>

    <select name="" id="" onchange="urlSectionId(this.value);">
    <option disabled selected value> -- Select an option -- </option>
    <?php foreach($sections as $section) { ?>
        <option value="<?= $section['section_name'] ?>"><?= $section['section_name']; ?></option>
    <?php } ?> 
    </select>
</form>
