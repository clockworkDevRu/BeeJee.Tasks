<?
class DBContext {
    
	public $db;
	
    function __construct() {
        $this->db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
	
    function query($strQuery, $args = array()) {
        $stmt = $this->db->prepare((string)$strQuery);
        $res = $stmt->execute($args);
        
		if ($res !== false) {
            try {
                
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
				
            } catch (Exception $ex) {
				
            }
        }
		
        return array();
    }
	
}
?>