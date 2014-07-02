<?php require_once("../model/session.php");
require_once("../model/user.php");
$tipo = $_POST['tipo'];

switch ($tipo){
	case"logar":
		//$senhaNormal=mysql_real_escape_string ($_POST['senha']);
		$senha =mysql_real_escape_string ($_POST['senha']);
		$user = mysql_real_escape_string ($_POST['user']);
	    $check = User::authenticate($user,$senha);
		
		if($check!=false) {
			$session->login($check);
			unset($_SESSION['wrong_login']);
			if(isset($_POST["lembrar_senha"])){
				$usuario=$_POST["user"];
				$tempo_expiracao= 3600; //uma hora
				setcookie("lembrar", $usuario, $tempo_expiracao);
			}
			header ("location: ../view/index.php");
			exit();
			//echo"<meta http-equiv='refresh' content='0;URL=../view/adminHome.php'>";
		}
		else {
			$_SESSION['mensagem'] = "erro";
			header ("location: ../view/login.php");
			exit();
			//echo"<meta http-equiv='refresh' content='0;URL=../view/login.php?type=a01'>";
		}
			
	break;

}
?>
