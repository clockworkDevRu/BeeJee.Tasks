<?
class User {
	
	public $id;
	public $name;
	public $password;
	
	function __construct($id, $name, $password) {
		$this->id = $id;
		$this->name = $name;
		$this->password = $password;
	}
	
	public static function find($name) {
        $db = new DBContext();
		
		$result = $db->query("SELECT id, name, password FROM users WHERE name = ?", [$name]);
		
		if (isset($result[0])) {
			
			$row = $result[0];	
			$user = new User($row['id'], $row['name'], $row['password']);
		
		} else {
			$user = null;
		}
		
		return $user;
    }
	
}
?>