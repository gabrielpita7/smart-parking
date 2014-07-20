<?php require_once "database.php";
Class Vaga {
	
	protected static $db_fields = array ('ID_Vagas','Total_Vagas','Largura_Vagas','Altura_Vagas','Total_Preferencial_Vagas');
	
	public static $table_name = "vagas";
	public $ID_Vagas;
	public $Total_Vagas;
	public $Largura_Vagas;
	public $Altura_Vagas;
	public $Total_Preferencial_Vagas;


public static function viewVaga($id,$count,$countDeficiente) {  
$vaga=self::find_by_id($id); ?>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-6 "> 
				<div class="col-md-8 ">
					Total de Vagas: <?php echo $vaga->Total_Vagas; ?>
				</div>
				<div class="col-md-8">
					Vagas Ocupadas: <?php echo $count;?>
				</div>


			</div>

			<div class="col-lg-6"> 
				<div class="col-md-8">
				Total de Vagas Preferenciais: <?php echo $vaga->Total_Preferencial_Vagas; ?>
				</div>
				<div class="col-md-8">
				Vagas Deficiente Ocupadas: <?php echo $countDeficiente;?>
				</div>
			</div>
		</div>
		<div id="morris-bar-chart"></div>
	</div>

<?php } 



/*DATABASE	*/
	
	public static function find_all() {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." ");
		return $result_array;
		}
	
	public static function find_by_id($id=0) {
		$vagas = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE ID_Vagas={$id} LIMIT 1");
		return empty($vagas) ? false : array_shift($vagas);
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
		$sql .= " WHERE ID_Vagas=$this->id" ;
		if(!$database->query($sql)) {
			echo mysql_error();
			}
		}

	public function delete() {
		global $database;
		$sql = "DELETE FROM ".self::$table_name." WHERE ID_Vagas=$this->id";
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
