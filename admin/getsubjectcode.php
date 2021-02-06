<?php
require_once('../enrollmentclass.php');

$course_code = " ";
if(empty($_GET['course_code'])) {
    $course_code = null;
} else {
    $course_code = $_GET['course_code'];
}

$yearlevel = " ";
if(empty($_GET['yearlevel'])) {
    $yearlevel = null;
} else {
    $yearlevel = $_GET['yearlevel'];
}

$term = " ";
if(empty($_GET['term'])) {
    $term = null;
} else {
    $term = $_GET['term'];
}

$subjectscode = $olenrollment->getSubjectCode($yearlevel,$term,$course_code);
$olenrollment->addSchedule($_POST);

?>

<form action="" method="post">
<select name="" id="" onchange="getSubjTitle(this.value); getSubjUnits(this.value); getSubjectId(this.value);">
    <option disabled selected value> -- Select an option -- </option>
    <?php foreach($subjectscode as $subjectcode) { ?>
        <option value="<?= $subjectcode['subject_code'] ?>"><?= $subjectcode['subject_code']; ?></option>
    <?php } ?> 
</select>
</form>