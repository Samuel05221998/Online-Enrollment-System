<?php
require_once('../enrollmentclass.php');
$olenrollment->logout();
header("Location: ../login.php?logout=You have been logout");
?>