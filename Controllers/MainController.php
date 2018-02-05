<?
class MainController extends BaseController {
	
	public $layouts = "Default";
	
	function index() {
		session_start();
		$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
		
		$this->template->vars('user', $user);
		$this->template->view('index');
	}
	
	function listTasks() {
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$order = isset($_GET['order']) ? $_GET['order'] : 'created';
		$orderMod = isset($_GET['ordermod']) ? $_GET['ordermod'] : 'DESC';
		
		session_start();
		$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
		
		$taskByPage = 3;
		
		$tasksCount = Task::countTasks();
		$pagesTotal = ceil($tasksCount / $taskByPage);
		
		$tasks = Task::fetchPage($page, $taskByPage, $order, $orderMod);
		
		$this->template->vars('user', $user);
		$this->template->vars('tasks', $tasks);
		$this->template->vars('page', $page);
		$this->template->vars('pagesTotal', $pagesTotal);
		$this->template->vars('order', $order);
		$this->template->vars('orderMod', $orderMod);
		$this->template->viewPartial('_tasks');
	}
	
	function addTask() {
		
		$result = 'success';
		
		if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['Task'])) {
			$taskForm = $_POST['Task'];
			
			$img = !empty($_FILES['task-img']['name']) ? $this->processImage($_FILES['task-img']) : null;
			
			$task = new Task(null, null, $taskForm['username'], $taskForm['email'], $taskForm['text'], $img);
			if (!$task->save()) {
				$result = 'error';
			}
		}
		
		$this->template->vars('result', $result);
		$this->template->viewPartial('_addtask');
	}
	
	function addTaskPreview() {
		
		if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['Task'])) {
			$taskForm = $_POST['Task'];
			
			$img = !empty($_FILES['task-img']['name']) ? $this->processImage($_FILES['task-img'], true) : null;
			
			$task = new Task(null, null, $taskForm['username'], $taskForm['email'], $taskForm['text'], $img);
		}
		
		$this->template->vars('task', $task);
		$this->template->viewPartial('_addtaskpreview');
	}
	
	function updateTask() {
		
		session_start();
		if (isset($_SESSION['user']) && $_SESSION['user']->name == 'admin') {
		
			$result = 'success';

			$task = Task::find(intval($_GET['id']));

			if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['Task'])) {
				$taskForm = $_POST['Task'];
				
				$task->text = $taskForm['text'];
				$task->completed = isset($taskForm['completed']) ? 1 : 0;
				
				if (!$task->save()) {
					$result = 'error';
				}
			}
			
			$this->template->vars('result', $result);
			$this->template->vars('task', $task);
			$this->template->viewPartial('_updatetask');
		
		} else {
			header('Location: ' . SITE_URL);
		}
	}
	
	private function processImage($file, $tmp = false) {
		$jpeg_quality = 90;
	
		$imageTypeArray = array(
			1 => 'gif',
			2 => 'jpg',
			3 => 'png'
		);
		
		$errors = array(
			1 => 'Превышен максимальный размер файла', 
			2 => 'Превышен максимальный размер файла', 
			3 => 'Ошибка при загрузке', 
			4 => 'Не выбран файл'
		); 
		
		if ( !$file['error'] == 0 ) { 
			throw new Exception($errors[$file['error']]);
		}
		
		if ( !@is_uploaded_file($file['tmp_name']) ) { 
			throw new Exception("Ошибка при загрузке");
		}
		
		if ( filesize($file['tmp_name']) > 10000000) {
			throw new Exception("Файл слишком большой");
		}
		
		$img = @getimagesize($file['tmp_name']);
		if ( !$img || !array_key_exists($img[2], $imageTypeArray) ) { 
			throw new Exception('Недопустимый формат файла');
		}
		
		$imageType = $imageTypeArray[$img[2]];
		$now = time(); 
		while(file_exists( SITE_PATH . 'Uploads' . DS . ($tmp ? 'tmp' . DS : '') . $now . "." . $imageType )) { 
			$now++; 
		}
		$uploadFilename = $now . "." . $imageType;

		$exif = @exif_read_data($file['tmp_name']);
		if( !empty( $exif['Orientation'] ) ) {
			$orientation = $exif['Orientation'];
		} else {
			$orientation = NULL;
		}
		
		$resImage = $this->resizeImage($file['tmp_name'], 320, 240);
		switch ($orientation) {
			case 3:
				$resImage = imagerotate( $resImage, 180, 0 );
				break;
			case 6:
				$resImage = imagerotate( $resImage, 270, 0 );
				break;
			case 8:
				$resImage = imagerotate( $resImage, 90, 0 );
				break;
		}
		
		if ( !@imagejpeg($resImage, SITE_PATH . 'Uploads' . DS . ($tmp ? 'tmp' . DS : '') . $uploadFilename, $jpeg_quality) ) {
			throw new Exception('Отсутствуют права для записи файлов');
		}
		
		return $uploadFilename;
	}
	
	private function imageCreateFromAny($filepath) { 
		$type = exif_imagetype($filepath);
		$allowedTypes = array( 
			1,  //gif 
			2,  //jpg 
			3  //png
		); 
		if (!in_array($type, $allowedTypes)) { 
			return false; 
		} 
		switch ($type) { 
			case 1: 
				$img = imageCreateFromGif($filepath); 
				break; 
			case 2: 
				$img = imageCreateFromJpeg($filepath); 
				break; 
			case 3: 
				$img = imageCreateFromPng($filepath); 
				break;
		}    
		return $img;  
	}
	
	private function resizeImage($filepath, $maxWidth, $maxHeight) {
		list($origWidth, $origHeight) = getimagesize($filepath);
	
		$width = $origWidth;
		$height = $origHeight;

		if ($height > $maxHeight) {
			$width = ($maxHeight / $height) * $width;
			$height = $maxHeight;
		}

		if ($width > $maxWidth) {
			$height = ($maxWidth / $width) * $height;
			$width = $maxWidth;
		}
	
		$image_p = imagecreatetruecolor($width, $height);
	
		$image = $this->imageCreateFromAny($filepath);
	
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $origWidth, $origHeight);
	
		return $image_p;
	}
	
}
?>