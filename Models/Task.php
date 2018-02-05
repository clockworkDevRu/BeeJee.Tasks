<?
class Task {
	
	public $id;
	public $created;
	public $username;
	public $email;
	public $text;
	public $img;
	public $completed;
	
	function __construct($id = null, $created = null, $username, $email, $text, $img = null, $completed = 0) {
		$this->id = $id;
		$this->created = $created;
		$this->username = $username;
		$this->email = $email;
		$this->text = $text;
		$this->img = $img;
		$this->completed = $completed;
	}
	
	public static function find($id) {
		$db = new DBContext();
		$result = $db->query("SELECT * FROM tasks WHERE id = ?", [$id]);
		
		if (count($result)) {
			
			$row = $result[0];
			$task = new Task($row['id'], $row['created'], $row['username'], $row['email'], $row['text'], $row['img'], $row['completed']);
		
		} else {
			$task = null;
		}
		
		return $task;
	}
	
	public static function findAll() {
		$db = new DBContext();
		$result = $db->query("SELECT * FROM tasks");
		
		if (count($result)) {
			$tasks = $result;
		} else {
			$tasks = null;
		}
		
		return $tasks;
	}
	
	public static function countTasks() {
		$db = new DBContext();
		$result = $db->query("SELECT count(*) as cnt FROM tasks");
		$count = $result[0]['cnt'];
		
		return $count;
	}
	
	public static function fetchPage($page, $taskByPage, $order = 'created', $orderMod = 'DESC') {
		$offset = ($page - 1) * $taskByPage;
		
		if (
			!in_array($order, array_keys(get_class_vars('Task'))) 
			|| !in_array($orderMod, ['ASC', 'DESC'])
		) {
			return null;
		}
		
		$dbh = (new DBContext())->db;
		$stmt = $dbh->prepare("SELECT * FROM tasks ORDER BY $order $orderMod LIMIT ? OFFSET ?");
		$stmt->bindValue(1, $taskByPage, PDO::PARAM_INT);
		$stmt->bindValue(2, $offset, PDO::PARAM_INT);
		
		if ($stmt->execute()) {
			$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$tasks = null;
		}
		
		return $tasks;
	}
	
	public function save() {
		$dbh = (new DBContext())->db;
		
		if (isset($this->id)) {
			
			$result = $dbh->prepare("UPDATE tasks SET text = ?, completed = ? WHERE id = ?")->execute([
				$this->text, 
				$this->completed, 
				$this->id
			]);
			
			return $result; 
			
		} else {
			
			$result = $dbh->prepare("INSERT INTO tasks (username, email, text, img) VALUES (?, ?, ?, ?)")->execute([
				$this->username, 
				$this->email, 
				$this->text,
				$this->img
			]);
			
			if ($result) {
				$this->id = $dbh->lastInsertId();
			} else {
				return false;
			}
		
		}
		
		return true;
	}
	
}
?>