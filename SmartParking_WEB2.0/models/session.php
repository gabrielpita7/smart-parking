<?php
class Session{
	
	private $logged_in=false;
	public $user_id;
	public $user_tipo;
	public $nome_usuario;
	
	
	function __construct(){
		session_start();
		$this->check_login();
	}
	
	public function is_logged_in(){
		return $this->logged_in;
	}
	
	public function login($user){
		if($user){
			$this->user_id = $_SESSION['user_id'] = $user->ID_Usuario;
			$this->user_tipo = $_SESSION['tipo'] = $user->Tipo_Usuario;
			$this->nome_usuario = $_SESSION['nome'] = $user->Nome_Usuario; 
			$this->logged_in=true;
		}
	}
	
	public function logout(){
		unset($_SESSION['user_id']);
		unset($this->ID_Usuario);
		unset($_SESSION['tipo']);
		unset($this->Tipo_Usuario);
		unset($_SESSION['nome']);
		unset($this->Nome_Usuario);
		$this->logged_in = false;
	}
	
	private function check_login(){
		if(isset($_SESSION['user_id'])){
			$this->ID_Usuario = $_SESSION['user_id'];
			$this->logged_in=true;
		}
		else{
			unset ($this->user_id);
			$this->logged_in=false;
		}
	}

} 
$session= new Session();
?>
