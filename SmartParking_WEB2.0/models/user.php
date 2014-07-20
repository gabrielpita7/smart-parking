<?php require_once "database.php";
Class User {
	
	protected static $db_fields = array ('ID_Usuario','Nome_Usuario','Email_Usuario','CPF_Usuario','CodigoAcesso_Usuario','Deficiente_Usuario','Tipo_Usuario','Cargo_Usuario','Senha_Usuario','CodigoVaga_Usuario');
	
	public static $table_name = "usuarios";
	public $ID_Usuario;
	public $Nome_Usuario;
	public $Email_Usuario;
	public $CPF_Usuario;
	public $CodigoAcesso_Usuario;
	public $Deficiente_Usuario;
	public $Tipo_Usuario;
	public $Cargo_Usuario;
	public $Senha_Usuario;
	public $CodigoVaga_Usuario;


public static function editUsuario($id) {  
$user=self::find_by_id($id); ?>
 		<div class="row">
        	<div class="col-lg-12">

        	<?php                         
              if(isset($_POST['senhaAtual'])){                        
                
                $senhaAtual =mysql_real_escape_string ($_POST['senhaAtual']);
                $senha1 = mysql_real_escape_string ($_POST['senha1']);
                $senha2 = mysql_real_escape_string ($_POST['senha2']);
                
                if($senha1 != $senha2) {
                    $_SESSION['error']="Por Favor, Digite as senhas iguais";                                        
                    header ("location: ../views/user.php");
                    exit();                    
                }
                else if($senhaAtual!=$user->Senha_Usuario){
                	$_SESSION['error']="Senha Atual incorreta!";                                        
                    header ("location: ../views/user.php");
                    exit();  
                }
                else {
                    $_SESSION['mensagemSucesso'] = "Senha Alterada com Sucesso";
                    $user->Senha_Usuario =  $senha1;
                    $user->update();               
                    header ("location: ../views/user.php");
                    exit();                    
                }
                
            }?> 
            <form id="editForm" method="post" class="form-horizontal">
				<?php 
                if(isset($_SESSION['error'])){ ?>                           
                   <div class="alert alert-success">
                        <?php echo $_SESSION['error']; ?>
                    </div> 
                <?php unset($_SESSION['error']); } 
                if(isset($_SESSION['mensagemSucesso'])){ ?>                           
                   <div class="alert alert-danger">
                        <?php echo $_SESSION['mensagemSucesso']; ?>
                    </div> 
                <?php unset($_SESSION['mensagemSucesso']); } ?>
                       
                    <div class="form-group">
                        <div class="col-lg-6"> 
                        <label class="col-md-3 control-label" for="disabledSelect">Nome:</label>
	                        <div class="col-md-8">
	                            <input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $user->Nome_Usuario;?>" disabled>
	                        </div>
                        </div>       
	                    <div class="col-lg-6"> 
	                        <label class="col-md-3 control-label" for="disabledSelect">Login:</label>
	                        <div class="col-md-8">
	                            <input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $user->CodigoAcesso_Usuario;?>" disabled>
	                        </div>
	                    </div>
                    </div>

	                <div class="form-group">
	                	<div class="col-lg-6">  
		                    <label class="col-md-3 control-label">Senha Atual:</label>
		                     <div class="col-md-8">
		                    	<input class="form-control" type="text" name="senhaAtual" />	                    
		                    </div>	
		                </div>
	                </div>

                    <div class="form-group">
                        <div class="col-lg-6"> 
                        <label class="col-md-3 control-label">Nova Senha:</label>
	                        <div class="col-md-8">
	                            <input class="form-control" type="text" name="senha1">
	                        </div>
                        </div>       
	                    <div class="col-lg-6"> 
	                        <label class="col-md-3 control-label">Repita Senha:</label>
	                        <div class="col-md-8">
	                            <input class="form-control" type="text" name="senha2">
	                        </div>
	                    </div>
                    </div>
                                                                                     
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-9">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <span class="text_button_padding">ou</span>
                  			<a class="text_button_padding link_button" href="../views/home.php">Cancelar</a>
                        </div>
                    </div>
                </form>       
            
             

            </div>
          </div>
	<?php } 


public static function viewUsuario($id) {  
$user=self::find_by_id($id); ?>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-6 "> 
				<div class="col-md-8 ">
					Nome: <?php echo $user->Nome_Usuario; ?>
				</div>
				<div class="col-md-8">
					CPF: <?php echo $user->CPF_Usuario; ?>
				</div>
				<div class="col-md-8">
					Cargo: <?php echo $user->Cargo_Usuario; ?>
				</div>
				<div class="col-md-8">
					Está Estacionado? <?php $codigoVaga = $user->CodigoVaga_Usuario; $estacionado=false;
					 if(!empty($codigoVaga) && $codigoVaga!=" "){ echo "Sim" ; $estacionado=true;} else{ echo "Não"; $estacionado=false;} ?>
				</div>
			</div>

			<div class="col-lg-6"> 
				<div class="col-md-8">
				Login: <?php echo $user->CodigoAcesso_Usuario; ?>
				</div>
				<div class="col-md-8">
				Tipo de Acesso: <?php echo $user->Tipo_Usuario; ?>
				</div>
				<?php if($estacionado) {?>
				<div class="col-md-8">
					</br>
				</div>
				<div class="col-md-8">
					Vaga Estacionada: <?php echo $codigoVaga; ?>
				</div>
				<?php }?>
			</div>
		</div>
	</div>

<?php }

public static function numberVagas(){
	$users = self::find_all();
	$count=0;
	foreach ($users as $user) {
		if(($user->CodigoVaga_Usuario != " ")&&($user->Deficiente_Usuario=="N")){
			$count++;
		}
	}

	return $count;
}

public static function numberVagasDeficiente(){
	$users = self::find_all();
	$count=0;
	foreach ($users as $user) {
		if(($user->CodigoVaga_Usuario != " ")&&($user->Deficiente_Usuario=="S")){
			$count++;
		}
	}

	return $count;
} 

public static function getSenha($login){
	$user = self::find_by_login($login);
	$senha = $user[0]->Senha_Usuario;
	//$senha = $user[0]->Senha_Usuario;
	return $senha;
}

public static function getName($login){
	$user = self::find_by_login($login);
	$nome = $user[0]->Nome_Usuario;
	//$senha = $user[0]->Senha_Usuario;
	return $nome;
}

public static function getCodigoVaga($id){
	$user=self::find_by_id($id);
	return $user->CodigoVaga_Usuario;
}

public static function setId($nome){
		$user=self::find_by_name($nome);
		echo $user->nome;
		echo $nome;
	}

public static function compareEmail($login,$email){
	$user = self::find_by_login($login);
	$user2 = self::find_by_email($email);
	$id = $user[0]->ID_Usuario;
	$id2 = $user2[0]->ID_Usuario;
	if($id===$id2 && $id!="" && $id!= ""){
		return true;
	}else{
		return false;
	}
	
}
	
/*DATABASE	*/
	public static function find_by_email($email=""){
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE Email_Usuario='{$email}' LIMIT 1 ");
		return $result_array;
	}
	
	public static function find_by_login($login="") {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE CodigoAcesso_Usuario='{$login}' LIMIT 1 ");
		return $result_array;
	}

	public static function authenticate($user,$senha) {
		$sql = "SELECT * FROM ".self::$table_name." ";
		$sql .= "WHERE CodigoAcesso_Usuario='{$user}' AND Senha_Usuario='{$senha}' LIMIT 1";
		$user = self::find_by_sql($sql);
		return empty($user) ? false : array_shift($user);
		}
	
	public static function find_all() {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." ");
		return $result_array;
		}
	
	public static function find_by_id($id=0) {
		$users = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE ID_Usuario={$id} LIMIT 1");
		return empty($users) ? false : array_shift($users);
		}
	
	public static function find_by_sql($sql="") {
		global $database;
		$query = $database->query($sql);
		$object_array = array();
		while ($row = $database->fetch_array($query)){
			$object_array[] = self::instantiate($row);  
			}
		return $object_array;
		}

	
	public static function instantiate($record) {
		$object = new self;
		foreach ($record as $attribute => $value) {
			if($object->has_attribute($object,$attribute) ) {
				$object->$attribute = $value;
			}
		}
		return $object;
	}

	private function has_attribute($object,$attribute) {
		$attributes = get_object_vars($object);
		return array_key_exists($attribute,$attributes);
		}
		
	
	public function create() {
		global $database;
		$attributes = self::sanitized_attributes($this);
		$sql = "INSERT INTO ".self::$table_name." ( ";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ( '";
		$sql .= join("','", array_values($attributes));
		$sql .= "')";
		if(!$database->query($sql)) {
			echo mysql_error();
			}
	}

	public function update() {
		global $database;
		$attributes = self::sanitized_attributes($this);
		$attributes_pairs = array();
		foreach($attributes as $key=>$value) {
			$attributes_pairs[] = "{$key} = '{$value}'";
			}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(" , ",$attributes_pairs);
		$sql .= " WHERE ID_Usuario=$this->ID_Usuario" ;
		if(!$database->query($sql)) {
			echo mysql_error();
			}
		}

	public function delete() {
		global $database;
		$sql = "DELETE FROM ".self::$table_name." WHERE ID_Usuario=$this->ID_Usuario";
		if(!$database->query($sql)) {
			echo mysql_error();
			}
		}
	
	protected static function attributes($object) {
		$atributtes = array();
		foreach(self::$db_fields as $field) {
			if(property_exists($object,$field)) {
				$atributtes[$field] = $object->$field;
				}
			}
		return $atributtes;	
	}
	
	protected function sanitized_attributes($object) {
		global $database;
		$clean_attributes = array();
		foreach($this->attributes($object) as $key=>$value) {
			$clean_attributes[$key] = $value;
			}
		return $clean_attributes;	
	}
	
}
