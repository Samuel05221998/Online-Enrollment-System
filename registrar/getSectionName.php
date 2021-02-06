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

$sections = $olenrollment->getSectionNameYT($yearlevel,$term,$course_code);
?>

<script>

function getSectionId(id) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else{
        xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
    
    xmlhttp.onreadystatechange= function(){
        if (this.readyState==4 && this.status==200) {
            document.getElementById('sectionid').innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET","getsectionid.php?value="+id, true);
    xmlhttp.send();
}
</script>

<form method = 'POST' action = ''>

    <select name="" id="" class="search-text" onchange="getsectionid(this.value);">
    <option disabled selected value> -- Select an option -- </option>
    <?php foreach($sections as $section) { ?>
        <option value="<?= $section['section_name'] ?>"><?= $section['section_name']; ?></option>
    <?php } ?> 
    </select>
    <div id="sectionid">
        <input type="hidden" name="" id="">
    </div>
</form>
