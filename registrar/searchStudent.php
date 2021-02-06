<?php

$host = 'localhost';
$dbname = 'enrollment_db';
$user = 'root';
$password = '';
$charset = 'utf8';
$pdo = new PDO(
	"mysql:host=$host;dbname=$dbname;charset=$charset", $user, $password, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	]
);

$data = [];
switch($_POST['type'])
{
    default :
    break;

    case "user":

    $stmt = $pdo->prepare("SELECT * FROM `students` WHERE `studentname` LIKE ?");
    $stmt->execute(["%" . $_POST['term'] . "%"]);
    while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
      $data[] = $row['studentname'];
    }
    break;
}

// (3) RETURN RESULT
$pdo = null;
echo json_encode($data);
?>