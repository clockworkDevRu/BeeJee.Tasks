<?
class Template {

	private $template;
	private $controller;
	private $layouts;
	private $vars = array();
	
	function __construct($layouts, $controllerName) {
		$this->layouts = $layouts;
		$this->controller = str_replace("Controller", "", $controllerName);
	}

	function vars($varname, $value) {
		if (isset($this->vars[$varname]) == true) {
			trigger_error("Unable to set var `" . $varname . "`. Already set, and overwrite not allowed.", E_USER_NOTICE);
			return false;
		}
		$this->vars[$varname] = $value;
		return true;
	}

	function view($name) {
		$pathLayout = SITE_PATH . "Views" . DS . "_Layouts" . DS . $this->layouts . ".php";		
		if (file_exists($pathLayout) == false) {
			trigger_error("Layout `" . $this->layouts . "` does not exist.", E_USER_NOTICE);
			return false;
		}
		
		$contentPage = SITE_PATH . "Views" . DS . $this->controller . DS . $name . ".php";
		if (file_exists($contentPage) == false) {
			trigger_error("Template `" . $name . "` does not exist.", E_USER_NOTICE);
			return false;
		}
		
		foreach ($this->vars as $key => $value) {
			$$key = $value;
		}

		include $pathLayout;
	}
	
	function viewPartial($name) {
		$contentPage = SITE_PATH . "Views" . DS . $this->controller . DS . $name . ".php";
		if (file_exists($contentPage) == false) {
			trigger_error("Template `" . $name . "` does not exist.", E_USER_NOTICE);
			return false;
		}
		
		foreach ($this->vars as $key => $value) {
			$$key = $value;
		}

		include $contentPage;
	}
	
}
?>