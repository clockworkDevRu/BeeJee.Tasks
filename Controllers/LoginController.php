<?
class LoginController extends BaseController {
	
	function index() {		
		
		session_start();
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			$name = $_POST['login-form']['login'];
			$password = $_POST['login-form']['password']; 
			
			$user = User::find($name);
			
			if (!empty($user) && password_verify($password, $user->password)) {
			
				$_SESSION['user'] = $user;
			
			}
		}
		
		header('Location: ' . SITE_URL);
	}
	
	function logout() {		
		
		session_start();
   
		if(session_destroy()) {
			header('Location: ' . SITE_URL);
		}
	}
	
}
?>