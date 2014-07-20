<?php require_once("../models/session.php");
$cod=$_GET['cod'];
if($cod=1){
	$session->logout();
}
header ("location: ../views/index.php");
exit();
?>
